# Software Requirements Specification (SRS)

## Scholar Metric — Faculty Evaluation & Anonymous Feedback Platform

| Field | Value |
|-------|-------|
| **Document Version** | 1.0 |
| **Date** | July 21, 2026 |
| **Project** | Scholar Metric |
| **Technology Stack** | Laravel 13, PHP 8.3+, MySQL, Tailwind CSS v4, Vite 8, Google Gemini API |
| **Status** | Implemented (as-built specification) |

---

## Table of Contents

1. [Introduction](#1-introduction)
2. [Overall Description](#2-overall-description)
3. [Scope of the Project](#3-scope-of-the-project)
4. [Functional Requirements](#4-functional-requirements)
5. [Non-Functional Requirements](#5-non-functional-requirements)
6. [Use Cases](#6-use-cases)
7. [Adopted Methodology](#7-adopted-methodology)
8. [Work Plan](#8-work-plan)
9. [System Architecture](#9-system-architecture)
10. [Database Design](#10-database-design)
11. [Diagram References](#11-diagram-references)
12. [Appendices](#12-appendices)

---

## 1. Introduction

### 1.1 Purpose

This Software Requirements Specification (SRS) describes the functional and non-functional requirements, architecture, database design, and development plan for **Scholar Metric**, a web-based faculty evaluation system for universities. The document serves as a reference for developers, testers, project managers, and stakeholders.

### 1.2 Intended Audience

- Project managers and business analysts
- Full-stack and backend developers
- QA engineers
- University administrators (product owners)
- Academic reviewers and thesis evaluators

### 1.3 Product Overview

Scholar Metric enables universities to:

- Manage academic structure (departments, courses, enrollments)
- Run time-bound faculty evaluation cycles
- Collect **anonymous** student feedback via unique tokens
- Moderate written comments using **Google Gemini AI**
- Generate administrative reports and exports
- Provide role-specific dashboards for administrators, faculty, and students

### 1.4 Definitions and Acronyms

| Term | Definition |
|------|------------|
| **Evaluation Cycle** | A time-bound period during which students submit feedback for assigned faculty/courses |
| **Feedback Token** | A UUID issued to a student for a specific evaluation/course/faculty combination |
| **Multi-tenancy** | Logical isolation of data per university via `university_id` |
| **Moderation** | AI or rule-based screening of free-text comments before storage/display |
| **SRS** | Software Requirements Specification |
| **UAT** | User Acceptance Testing |

### 1.5 References

- Laravel 13 Documentation: https://laravel.com/docs
- Google Gemini API Documentation
- Project source: `/home/nomi/scholar_metric`
- Work plan CSV: `docs/scholar-metric-work-plan.csv`
- PlantUML diagrams: `docs/diagrams/*.puml`

---

## 2. Overall Description

### 2.1 Product Perspective

Scholar Metric is a standalone web application built on Laravel 13. It uses server-rendered Blade views with Tailwind CSS, session-based authentication, and a MySQL database. External integration is limited to the Google Gemini API for content moderation.

### 2.2 User Classes and Characteristics

| User Class | Description | Primary Functions |
|------------|-------------|-------------------|
| **Administrator** | University staff managing the evaluation program | User/course management, evaluation setup, reports, moderation review |
| **Faculty** | Instructors being evaluated | View aggregated feedback and dashboard metrics |
| **Student** | Enrolled learners | Submit anonymous evaluations during active cycles |
| **System** | Automated processes | Lifecycle scheduling, token generation, notifications |

### 2.3 Operating Environment

- **Server:** Linux with PHP 8.3+, Composer, Node.js (Vite build)
- **Database:** MySQL (configured as `scholar` in `.env.example`)
- **Client:** Modern web browsers (Chrome, Firefox, Edge, Safari)
- **External Service:** Google Gemini API (`GEMINI_API_KEY`)

### 2.4 Design and Implementation Constraints

- Laravel 13 framework conventions must be followed
- Single active or scheduled evaluation cycle at any time
- Student identity must not be stored on feedback submission records
- No public REST API in current release (web routes only)
- Pest 4 used for automated testing

### 2.5 Assumptions and Dependencies

- Administrators register first and provision their university from email domain
- Students and faculty accounts are created by administrators
- Gemini API key may be absent; system falls back to local word-filter moderation
- Daily scheduler (`evaluation:process-lifecycle`) is configured in production
- Email notifications are partially implemented (database notifications are primary channel)

---

## 3. Scope of the Project

### 3.1 In Scope

1. Multi-tenant university management
2. Role-based authentication and authorization (admin, faculty, student)
3. Course and department management with faculty/student assignments
4. Evaluation cycle wizard with lifecycle automation
5. UUID-based anonymous feedback submission
6. AI-powered comment moderation (Gemini + local fallback)
7. Faculty dashboards and feedback viewing
8. Admin reporting with CSV/Excel export
9. Profile management (name, phone, avatar, password)
10. Database notifications for evaluation events

### 3.2 Out of Scope

1. Native mobile applications
2. Student self-registration
3. Public API endpoints
4. Faculty public response to feedback (field exists, feature incomplete)
5. Advanced analytics (faculty analytics page is placeholder)
6. SSO/LDAP/OAuth integration
7. Payment or subscription billing
8. Multi-language UI localization

### 3.3 System Boundaries

```
[Browser] ←→ [Laravel Web App] ←→ [MySQL]
                    ↓
            [Google Gemini API]
            [Public File Storage - Avatars]
```

---

## 4. Functional Requirements

### 4.1 Authentication & Authorization

| ID | Requirement | Priority |
|----|-------------|----------|
| FR-01 | The system shall allow users to log in with email, password, and selected role (admin/faculty/student). | High |
| FR-02 | The system shall reject login when the selected role does not match the account role. | High |
| FR-03 | The system shall allow new university administrators to self-register at `/register`. | High |
| FR-04 | On admin registration, the system shall auto-create or associate a `University` record from the email domain. | High |
| FR-05 | The system shall provide admin password reset via forgot-password flow. | Medium |
| FR-06 | The system shall enforce role-based route access via middleware (`admin`, `faculty`, `student`). | High |
| FR-07 | The system shall redirect authenticated users away from guest routes to their role dashboard. | Medium |

### 4.2 User Management (Admin)

| ID | Requirement | Priority |
|----|-------------|----------|
| FR-10 | Admin shall create, view, edit, activate/deactivate, and recover user accounts. | High |
| FR-11 | Admin shall view paginated lists of students and faculty. | High |
| FR-12 | Admin shall assign temporary passwords and send recovery emails. | Medium |
| FR-13 | Admin dashboard shall display counts of students, faculty, and courses. | Medium |

### 4.3 Academic Structure Management

| ID | Requirement | Priority |
|----|-------------|----------|
| FR-20 | Admin shall create and list courses with title, code, semester, credit hours, and department. | High |
| FR-21 | Admin shall assign faculty to courses via pivot table (`course_user` with optional `term`). | High |
| FR-22 | Admin shall assign students to courses. | High |
| FR-23 | Admin shall manage departments including nested course CRUD and enrollment assignment. | High |

### 4.4 Evaluation Management

| ID | Requirement | Priority |
|----|-------------|----------|
| FR-30 | Admin shall create evaluations through a 3-step wizard (metadata → faculty/courses → publish). | High |
| FR-31 | Evaluation shall support statuses: `draft`, `scheduled`, `active`, `closed`, `archived`. | High |
| FR-32 | Only one evaluation may be in `scheduled` or `active` status at a time. | High |
| FR-33 | On publish, system shall generate a unique UUID token per enrolled student per course/faculty pair. | High |
| FR-34 | System shall activate scheduled evaluations when `start_date <= today` and no other evaluation is active. | High |
| FR-35 | System shall close active evaluations when `end_date < today`. | High |
| FR-36 | System shall notify students and faculty on evaluation publish, activation, and closure. | Medium |

### 4.5 Student Feedback

| ID | Requirement | Priority |
|----|-------------|----------|
| FR-40 | Student dashboard shall show pending and completed evaluations based on tokens. | High |
| FR-41 | Student shall submit feedback only with a valid, unused token for an active evaluation. | High |
| FR-42 | Feedback form shall capture 7 rating dimensions plus overall rating (1–5 scale). | High |
| FR-43 | Feedback form shall capture text fields: comments, what worked well, what could improve, recommendation. | High |
| FR-44 | Each token shall be usable only once; upon submission `is_used` shall be set to true. | High |
| FR-45 | Stored feedback records shall not contain `student_id`. | High |
| FR-46 | Student shall view feedback submission history. | Medium |
| FR-47 | Student shall view enrolled courses and assigned teachers. | Medium |

**Rating question IDs:** `clarity`, `materials`, `responsiveness`, `fairness`, `practical`, `organization`, `overall_rating`

**Text question IDs:** `comments`, `what_worked_well`, `what_could_improve`, `recommendation`

### 4.6 Content Moderation

| ID | Requirement | Priority |
|----|-------------|----------|
| FR-50 | System shall moderate all text answers via `GeminiModerationService` before persistence. | High |
| FR-51 | Moderation shall return status, toxicity score, reason, categories, and cleaned comment. | High |
| FR-52 | If Gemini API is unavailable, system shall fall back to local word-filter moderation. | High |
| FR-53 | Admin shall review moderation log at `/admin/moderation`. | Medium |

### 4.7 Faculty Portal

| ID | Requirement | Priority |
|----|-------------|----------|
| FR-60 | Faculty dashboard shall display metrics, rating trends, and recent comments. | High |
| FR-61 | Faculty shall browse paginated feedback with filters. | High |
| FR-62 | Faculty analytics page shall be accessible (placeholder in current release). | Low |

### 4.8 Reporting (Admin)

| ID | Requirement | Priority |
|----|-------------|----------|
| FR-70 | Admin shall generate reports filtered by semester, department, evaluation, and faculty. | High |
| FR-71 | Report types shall include: faculty, course, department, evaluation, questions, comments, AI moderation. | High |
| FR-72 | Admin shall export reports in CSV and Excel formats. | High |
| FR-73 | Admin shall print report views. | Medium |
| FR-74 | Reports shall respect university tenant scope where applicable. | High |

### 4.9 Profile Management

| ID | Requirement | Priority |
|----|-------------|----------|
| FR-80 | All roles shall update profile information (name, phone). | Medium |
| FR-81 | All roles shall change password with validation. | Medium |
| FR-82 | Users shall upload and remove profile avatars stored on public disk. | Medium |

---

## 5. Non-Functional Requirements

### 5.1 Security

| ID | Requirement |
|----|-------------|
| NFR-01 | Passwords shall be hashed using Laravel's bcrypt/argon facilities. |
| NFR-02 | Session regeneration shall occur on login. |
| NFR-03 | Role middleware shall prevent horizontal privilege escalation between portals. |
| NFR-04 | Feedback anonymity shall be enforced at the data model level (no student FK on `feedbacks`). |

### 5.2 Performance & Scalability

| ID | Requirement |
|----|-------------|
| NFR-10 | Database shall be used for cache, sessions, and queues (as per `.env.example`). |
| NFR-11 | Report queries shall support filtering to limit result sets. |
| NFR-12 | Gemini API calls shall timeout after 10 seconds with up to 3 retry attempts. |

### 5.3 Reliability & Availability

| ID | Requirement |
|----|-------------|
| NFR-20 | Health check endpoint `/up` shall be available for monitoring. |
| NFR-21 | Evaluation lifecycle shall run daily via scheduler and on each web request via middleware. |
| NFR-22 | Evaluation publish shall use database transactions. |

### 5.4 Usability

| ID | Requirement |
|----|-------------|
| NFR-30 | UI shall use responsive Tailwind CSS layouts per role (`admin`, `faculty`, `student` components). |
| NFR-31 | Unmatched routes shall redirect users to role dashboard instead of generic 404 pages. |

### 5.5 Maintainability & Testability

| ID | Requirement |
|----|-------------|
| NFR-40 | Code shall follow Laravel 13 conventions and Pint formatting. |
| NFR-41 | Feature tests (Pest) shall cover auth, roles, evaluations, reports, and profiles. |
| NFR-42 | Business logic shall reside in Services and Repositories, not solely in controllers. |

### 5.6 Auditability

| ID | Requirement |
|----|-------------|
| NFR-50 | Moderation decisions shall store original comment, cleaned comment, status, score, and timestamp. |
| NFR-51 | Evaluation lifecycle shall record `activated_at` and `closed_at` timestamps. |

---

## 6. Use Cases

### 6.1 Use Case Summary

| UC ID | Name | Primary Actor |
|-------|------|---------------|
| UC-01 | Register University Admin | Administrator |
| UC-02 | Manage Users | Administrator |
| UC-03 | Manage Courses & Enrollments | Administrator |
| UC-04 | Manage Departments | Administrator |
| UC-05 | Create & Publish Evaluation | Administrator |
| UC-06 | View Reports & Export | Administrator |
| UC-07 | Review Moderation Log | Administrator |
| UC-08 | Login / Logout | All |
| UC-09 | Manage Profile | All |
| UC-10 | View Dashboard & Metrics | Faculty, Student |
| UC-11 | View Feedback Results | Faculty |
| UC-12 | View Pending Evaluations | Student |
| UC-13 | Submit Anonymous Feedback | Student |
| UC-14 | Process Evaluation Lifecycle | System |
| UC-15 | Generate Feedback Tokens | System |
| UC-16 | Send Notifications | System |
| UC-17 | Moderate Comments | System / Gemini AI |

### 6.2 Detailed Use Case — UC-13: Submit Anonymous Feedback

| Field | Description |
|-------|-------------|
| **Actor** | Student |
| **Preconditions** | Student is authenticated; holds valid unused token; evaluation is active |
| **Main Flow** | 1. Student opens feedback form via dashboard or course link. 2. Student selects course/instructor from pending tokens. 3. Student rates 7 dimensions and overall rating. 4. Student enters text comments. 5. System moderates text via Gemini. 6. System saves `feedbacks` and `feedback_answers`. 7. System marks token as used. 8. Student sees confirmation. |
| **Alternate Flow** | Token already used → error. Evaluation not active → form unavailable. Moderation rejects content → submission blocked or flagged per policy. |
| **Postconditions** | Anonymous feedback stored; token marked used; faculty can view aggregated results |

**Diagram:** See `docs/diagrams/use-case-diagram.puml`

---

## 7. Adopted Methodology

### 7.1 Methodology: Agile (Scrum-Inspired) with Iterative Incremental Delivery

The project follows an Agile approach with six development phases reflected in migration history and modular test coverage:

| Phase | Focus | Evidence |
|-------|-------|----------|
| Phase 1 | Foundation (auth, roles, multi-tenancy) | User migrations, AuthController, middleware |
| Phase 2 | Academic management | Courses, departments, enrollments |
| Phase 3 | Evaluation engine | Evaluations, tokens, lifecycle command |
| Phase 4 | Feedback & anonymity | Feedbacks, FeedbackAnswers, Gemini moderation |
| Phase 5 | Reporting | ReportService, exports, moderation log |
| Phase 6 | Polish & deployment | Profiles, UI layouts, UAT |

### 7.2 Scrum Elements

- **Sprint length:** 2 weeks (recommended)
- **Product backlog:** Functional requirements FR-01 through FR-82
- **Definition of Done:** Code complete, Pest tests pass, Pint formatted, role access verified

### 7.3 Quality Practices

- Test-driven development for critical paths (auth, evaluations, reports)
- Service/Repository separation for maintainability
- Event-driven notifications decoupled from lifecycle command

---

## 8. Work Plan

### 8.1 Schedule Overview

Total planned duration: **12 weeks** (approximately 60 working days)

| Phase | Duration | Key Deliverables |
|-------|----------|------------------|
| Initiation | 5 days | SRS, scope, architecture decision |
| Foundation | 10 days | Auth, roles, multi-tenancy |
| Academic Management | 12 days | Courses, departments, user admin |
| Evaluation Engine | 15 days | Wizard, tokens, lifecycle |
| Feedback & Anonymity | 12 days | Submission flow, AI moderation |
| Reporting | 10 days | Reports, exports, moderation UI |
| Polish & Deployment | 8 days | UAT, security review, go-live |
| Closure | 3 days | Handover, support plan |

### 8.2 MS Project Import

Import file: **`docs/scholar-metric-work-plan.csv`**

**MS Project steps:**

1. Open Microsoft Project
2. File → New → Blank Project
3. Project → Project Information → set start date (e.g., 2026-04-01)
4. File → Open → select `scholar-metric-work-plan.csv`
5. Use Text Import Wizard: delimiter = comma, map columns (ID, Name, Duration, Predecessors, Resource Names)
6. Verify task hierarchy via Outline Level column
7. Switch to Gantt Chart view

---

## 9. System Architecture

### 9.1 Architectural Style

**Layered MVC** with Service and Repository layers, event-driven notifications, and scheduled batch processing.

```
Presentation  → Blade Views + Tailwind CSS + Vite
Application   → Controllers + Middleware + Form Requests
Domain        → Eloquent Models + Events/Listeners
Infrastructure→ MySQL + File Storage + Gemini API + Queue/Cache
```

### 9.2 Key Components

| Layer | Components |
|-------|------------|
| Controllers | `AuthController`, `AdminController`, `FacultyController`, `StudentController`, `ProfileController`, `ReportController` |
| Services | `EvaluationService`, `ReportService`, `GeminiModerationService` |
| Repositories | `EvaluationRepository`, `FeedbackRepository` |
| Middleware | `AdminMiddleware`, `FacultyMiddleware`, `StudentMiddleware`, `UpdateEvaluationStatuses` |
| Commands | `ProcessEvaluationsLifecycle` (`evaluation:process-lifecycle`) |
| Events | `EvaluationActivated`, `EvaluationClosed` |

### 9.3 Deployment View

- Web server (Apache/Nginx) → `public/index.php`
- PHP-FPM running Laravel application
- MySQL database server
- Cron entry: `* * * * * php artisan schedule:run`
- Optional: queue worker for background jobs

**Diagram:** See `docs/diagrams/architecture-diagram.puml`

### 9.4 Sequence Diagrams

| Scenario | File |
|----------|------|
| Admin publishes evaluation | `docs/diagrams/sequence-publish-evaluation.puml` |
| Student submits feedback | `docs/diagrams/sequence-submit-feedback.puml` |
| Evaluation lifecycle | `docs/diagrams/sequence-evaluation-lifecycle.puml` |

---

## 10. Database Design

### 10.1 Entity Summary

| Table | Description |
|-------|-------------|
| `universities` | Tenant root entity |
| `users` | All system users (admin, faculty, student) |
| `courses` | Academic course catalog |
| `course_user` | Faculty teaching and student enrollment pivot |
| `evaluations` | Evaluation cycle definitions |
| `evaluation_faculty` | Faculty included in a cycle |
| `evaluation_courses` | Courses (with assigned faculty) in a cycle |
| `feedback_tokens` | Anonymous submission tokens |
| `feedbacks` | Anonymous submission header (no student_id) |
| `feedback_answers` | Per-question ratings and moderated text |
| `notifications` | Laravel database notifications |

### 10.2 Evaluation Status State Machine

```
draft ──publish──► scheduled ──activate──► active ──close──► closed ──archive──► archived
```

**Constraint:** At most one evaluation in `scheduled` OR `active` at any time.

### 10.3 Anonymity Model

```
feedback_tokens.student_id  →  Used for authorization only (token lookup)
feedbacks                     →  NO student_id column
feedback_answers              →  Linked to feedbacks only
```

Faculty and administrators see aggregated/anonymous results without student attribution.

### 10.4 Moderation Schema (`feedback_answers`)

| Column | Purpose |
|--------|---------|
| `moderation_status` | approved / flagged / rejected |
| `toxicity_score` | 0.0 – 1.0 |
| `moderation_categories` | JSON array of detected categories |
| `original_comment` | Raw student input |
| `cleaned_comment` | Sanitized text for display |
| `moderated_at` | Timestamp of moderation |

### 10.5 Recommended Indexes

- `feedback_tokens(token)` UNIQUE
- `feedback_tokens(student_id, is_used)`
- `evaluations(status, start_date, end_date)`
- `users(university_id, role)`
- `feedback_answers(feedback_id, question_id)`

**Diagram:** See `docs/diagrams/erd.puml` and `docs/diagrams/class-diagram.puml`

---

## 11. Diagram References

All diagrams are provided as PlantUML source files. Render with PlantUML CLI, VS Code extension, or https://www.plantuml.com/plantuml

| Diagram | File |
|---------|------|
| Use Case Diagram | `docs/diagrams/use-case-diagram.puml` |
| Entity Relationship Diagram | `docs/diagrams/erd.puml` |
| Architecture Design | `docs/diagrams/architecture-diagram.puml` |
| Sequence — Publish Evaluation | `docs/diagrams/sequence-publish-evaluation.puml` |
| Sequence — Submit Feedback | `docs/diagrams/sequence-submit-feedback.puml` |
| Sequence — Evaluation Lifecycle | `docs/diagrams/sequence-evaluation-lifecycle.puml` |
| Class Diagram | `docs/diagrams/class-diagram.puml` |

**Render all diagrams (requires PlantUML/Java):**

```bash
cd docs/diagrams
plantuml *.puml
```

---

## 12. Appendices

### Appendix A — Route Map (Summary)

| Prefix | Middleware | Purpose |
|--------|------------|---------|
| `/login`, `/register` | guest | Authentication |
| `/admin/*` | auth, admin | Administration |
| `/faculty/*` | auth, faculty | Faculty portal |
| `/student/*` | auth, student | Student portal |

Full route definitions: `routes/web.php`

### Appendix B — Test Coverage Summary

| Test File | Coverage Area |
|-----------|---------------|
| `Auth/LoginTest.php` | Role-based login |
| `Auth/RegisterTest.php` | Admin registration |
| `RoleMiddlewareTest.php` | Access control |
| `AdminUsersTest.php` | User management |
| `EvaluationTest.php` | Publish + anonymous submission |
| `AdminReportsTest.php` | Reports and exports |
| `FacultyDashboardTest.php` | Metrics and lifecycle |
| `ProfileManagementTest.php` | Profile CRUD |

### Appendix C — Environment Variables

| Variable | Purpose |
|----------|---------|
| `DB_DATABASE` | Database name (default: `scholar`) |
| `GEMINI_API_KEY` | Google Gemini API key for moderation |
| `APP_URL` | Application base URL |

### Appendix D — Document Revision History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-07-21 | Project Team | Initial as-built SRS |

---

*End of Document*
