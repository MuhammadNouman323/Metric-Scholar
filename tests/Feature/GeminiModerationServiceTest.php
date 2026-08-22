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
