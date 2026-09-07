<?php

use App\Services\GeminiModerationService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config()->set('services.gemini.api_key', null);
    config()->set('services.gemini.model', 'gemini-test-model');
});

test('local filter approves constructive feedback with zero score', function () {
    $result = (new GeminiModerationService)->localModerate('The lectures were clear and the materials were helpful.');

    expect($result['status'])->toBe('approved')
        ->and($result['toxicity_score'])->toBe(0)
        ->and($result['categories'])->toBe([]);
});

test('local filter flags mild slang with graduated scores', function () {
    $service = new GeminiModerationService;

    $single = $service->localModerate('This course damn near broke me, but I learned a lot.');
    $multiple = $service->localModerate('This class sucks, the assignments are crap, and the workload is hell.');

    expect($single['status'])->toBe('flagged')
        ->and($single['toxicity_score'])->toBe(30)
        ->and($multiple['status'])->toBe('flagged')
        ->and($multiple['toxicity_score'])->toBe(40)
        ->and($multiple['toxicity_score'])->not->toBe($single['toxicity_score']);
});

test('local filter flagged score is capped at 60 and cleans words', function () {
    $result = (new GeminiModerationService)->localModerate('This sucks, that sucks, everything is crap, pure hell, total piss, so frustrating.');

    expect($result['status'])->toBe('flagged')
        ->and($result['toxicity_score'])->toBeLessThanOrEqual(60)
        ->and($result['cleaned_comment'])->toContain('****');
});

test('local filter rejects offensive language with graduated scores capped at 95', function () {
    $service = new GeminiModerationService;

    $single = $service->localModerate('The professor is an idiot.');
    $multiple = $service->localModerate('You are an idiot, this class is trash, absolute garbage.');

    expect($single['status'])->toBe('rejected')
        ->and($single['toxicity_score'])->toBe(85)
        ->and($multiple['status'])->toBe('rejected')
        ->and($multiple['toxicity_score'])->toBe(89)
        ->and($multiple['toxicity_score'])->toBeLessThanOrEqual(95);
});

test('local filter rejects extremely short comments', function () {
    $result = (new GeminiModerationService)->localModerate('ok');

    expect($result['status'])->toBe('rejected')
        ->and($result['toxicity_score'])->toBe(90)
        ->and($result['categories'])->toContain('meaningless');
});

test('moderate falls back to local filter when api key is blank without http calls', function () {
    Http::fake();

    $result = (new GeminiModerationService)->moderate('This class sucks.');

    expect($result['status'])->toBe('flagged');

    Http::assertNothingSent();
});

test('moderate parses valid gemini response and normalizes score types', function () {
    config()->set('services.gemini.api_key', 'test-key');

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [
                ['content' => ['parts' => [['text' => json_encode([
                    'status' => 'flagged',
                    'toxicity_score' => '65.4',
                    'reason' => 'Mild slang.',
                    'categories' => ['slang'],
                    'cleaned_comment' => 'This class *****.',
                ])]]]],
            ],
        ]),
    ]);

    $result = (new GeminiModerationService)->moderate('This class sucks.');

    expect($result['status'])->toBe('flagged')
        ->and($result['toxicity_score'])->toBe(65)
        ->and($result['toxicity_score'])->toBeInt()
        ->and($result['cleaned_comment'])->toBe('This class *****.');
});

test('moderate clamps out of range toxicity scores from gemini', function () {
    config()->set('services.gemini.api_key', 'test-key');

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [
                ['content' => ['parts' => [['text' => json_encode([
                    'status' => 'rejected',
                    'toxicity_score' => 250,
                    'reason' => 'Toxic.',
                    'categories' => [],
                    'cleaned_comment' => 'x',
                ])]]]],
            ],
        ]),
    ]);

    $result = (new GeminiModerationService)->moderate('some comment here');

    expect($result['toxicity_score'])->toBe(100);
});

test('moderate falls back to local filter when gemini returns invalid status', function () {
    config()->set('services.gemini.api_key', 'test-key');

    Http::fake(function (Request $request) {
        return Http::response([
            'candidates' => [
                ['content' => ['parts' => [['text' => json_encode([
                    'status' => 'maybe',
                    'toxicity_score' => 50,
                    'reason' => 'Unclear.',
                ])]]]],
            ],
        ]);
    });

    $result = (new GeminiModerationService)->moderate('This class sucks.');

    expect($result['status'])->toBe('flagged')
        ->and($result['toxicity_score'])->toBe(30)
        ->and($result['reason'])->toBe('Feedback contains mild slang or informal language.');
});

test('moderate parses gemini json embedded in prose and markdown fences', function () {
    config()->set('services.gemini.api_key', 'test-key');

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [
                ['content' => ['parts' => [['text' => "Here is the moderation result:\n"
                    ."```json\n"
                    .json_encode([
                        'status' => 'flagged',
                        'toxicity_score' => 42,
                        'reason' => 'Mild slang detected.',
                        'categories' => ['slang'],
                        'cleaned_comment' => 'This course ****.',
                    ], JSON_PRETTY_PRINT)
                    ."\n```\nHope that helps!"]]]],
            ],
        ]),
    ]);

    $result = (new GeminiModerationService)->moderate('This course is garbage but great ethics.');

    expect($result['status'])->toBe('flagged')
        ->and($result['toxicity_score'])->toBe(42)
        ->and($result['cleaned_comment'])->toBe('This course ****.');
});

test('moderate normalizes gemini status casing', function () {
    config()->set('services.gemini.api_key', 'test-key');

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [
                ['content' => ['parts' => [['text' => json_encode([
                    'status' => 'Flagged',
                    'toxicity_score' => 30,
                    'reason' => 'Slang.',
                    'cleaned_comment' => 'x',
                ])]]]],
            ],
        ]),
    ]);

    $flagged = (new GeminiModerationService)->moderate('This class sucks.');

    expect($flagged['status'])->toBe('flagged');
});

test('moderate maps gemini status aliases to canonical values', function () {
    config()->set('services.gemini.api_key', 'test-key');

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [
                ['content' => ['parts' => [['text' => json_encode([
                    'status' => 'reject',
                    'toxicity_score' => 80,
                    'reason' => 'Toxic.',
                    'cleaned_comment' => 'x',
                ])]]]],
            ],
        ]),
    ]);

    $rejected = (new GeminiModerationService)->moderate('This class sucks and the professor is a moron.');

    expect($rejected['status'])->toBe('rejected');
});

test('local filter catches inflectional and compound variants', function () {
    $service = new GeminiModerationService;

    $bullshit = $service->localModerate('This syllabus is complete bullshit.');
    expect($bullshit['status'])->toBe('rejected');

    $crappy = $service->localModerate("The lab equipment is crappy.");
    expect($crappy['status'])->toBe('flagged')
        ->and($crappy['cleaned_comment'])->toContain('****');

    $stretched = $service->localModerate('These lectures were shiiit.');
    expect($stretched['status'])->toBe('rejected');

    $leet = $service->localModerate('Absolutely cr4p experience.');
    expect($leet['status'])->toBe('flagged');
});

test('local filter does not flag benign words via suffix or stretch matching', function () {
    $service = new GeminiModerationService;

    $approved = $service->localModerate('The course was well organized, clear, and helped me learn.');
    expect($approved['status'])->toBe('approved')
        ->and($approved['toxicity_score'])->toBe(0);

    $fantastic = $service->localModerate('This was a fantastic class and I recommend it.');
    expect($fantastic['status'])->toBe('approved');

    $diet = $service->localModerate('The professor discussed healthy diet during the break.');
    expect($diet['status'])->toBe('approved');
});
