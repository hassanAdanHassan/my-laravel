# Implementation Plan: Course Content Structure

## Overview

Implement the course detail page with a three-level content hierarchy (Course → Chapter → Lesson), enrollment system, and progress tracking. Follows the existing Laravel/AdminLTE conventions: migrations first, then models, middleware, form requests, controllers, routes, and Blade views.

## Tasks

- [ ] 1. Create database migrations
  - [ ] 1.1 Create `create_courses_table` migration
    - Add all columns: `instructor_id` (FK → users), `title`, `description`, `thumbnail`, `price`, `difficulty`, `duration_minutes`, `is_published`, timestamps
    - _Requirements: 1.1, 6.1_
  - [ ] 1.2 Create `create_chapters_table` migration
    - Add all columns: `course_id` (FK → courses, cascadeOnDelete), `title`, `description`, `display_order`, timestamps
    - _Requirements: 2.1, 6.2_
  - [ ] 1.3 Create `create_lessons_table` migration
    - Add all columns: `chapter_id` (FK → chapters, cascadeOnDelete), `title`, `type` (enum: video/article/pdf/quiz), `duration_minutes`, `content`, `video_url`, `is_preview`, `display_order`, timestamps
    - _Requirements: 2.2, 2.3, 2.4, 3.4_
  - [ ] 1.4 Create `create_enrollments_table` migration
    - Add columns: `user_id` (FK → users), `course_id` (FK → courses), `enrolled_at`, timestamps
    - Add unique constraint on `[user_id, course_id]`
    - _Requirements: 4.2_
  - [ ] 1.5 Create `create_lesson_progress_table` migration
    - Add columns: `user_id` (FK → users), `lesson_id` (FK → lessons), `completed_at`, timestamps
    - Add unique constraint on `[user_id, lesson_id]`
    - _Requirements: 5.2_

- [ ] 2. Implement Eloquent models
  - [ ] 2.1 Create `Course` model (`app/Models/Course.php`)
    - Define `$fillable`, relationships: `instructor()`, `chapters()` (ordered by `display_order`), `enrollments()`
    - Add `getLessonCountAttribute()` computed attribute
    - _Requirements: 1.1, 1.3_
  - [ ] 2.2 Create `Chapter` model (`app/Models/Chapter.php`)
    - Define `$fillable`, relationships: `course()`, `lessons()` (ordered by `display_order`)
    - _Requirements: 2.1, 2.2_
  - [ ] 2.3 Create `Lesson` model (`app/Models/Lesson.php`)
    - Define `$fillable`, cast `is_preview` to boolean, relationships: `chapter()`, `progress()`
    - _Requirements: 2.3, 2.4_
  - [ ] 2.4 Create `Enrollment` model (`app/Models/Enrollment.php`)
    - Define `$fillable`, relationships: `user()`, `course()`
    - _Requirements: 4.2_
  - [ ] 2.5 Create `LessonProgress` model (`app/Models/LessonProgress.php`)
    - Define `$fillable`, relationships: `user()`, `lesson()`
    - _Requirements: 5.2_
  - [ ] 2.6 Extend `User` model with new relationships and helper methods
    - Add `enrollments()`, `lessonProgress()`, `taughtCourses()` relationships
    - Add `isInstructorOrAdmin(): bool` and `isEnrolledIn(Course $course): bool` methods
    - _Requirements: 3.1, 3.2, 3.3, 4.1, 6.1_
  - [ ]* 2.7 Write property test for `Course` model aggregate counts
    - **Property 2: Course page displays correct aggregate counts**
    - **Validates: Requirements 1.3**
  - [ ]* 2.8 Write property test for display order ordering
    - **Property 3: Content displayed in ascending display_order**
    - **Validates: Requirements 2.1, 2.2**
  - [ ]* 2.9 Write property test for default display order assignment
    - **Property 11: Default display order equals count plus one**
    - **Validates: Requirements 6.2, 6.3**

- [ ] 3. Checkpoint — run migrations and verify models
  - Run `php artisan migrate` and confirm all five tables are created
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 4. Create `instructor` middleware
  - [ ] 4.1 Create `app/Http/Middleware/Instructor.php`
    - Allow through if `auth()->user()->isInstructorOrAdmin()`, otherwise abort(403)
    - Register the middleware alias `instructor` in `bootstrap/app.php` (or `Kernel.php` for Laravel 10)
    - _Requirements: 6.5_
  - [ ]* 4.2 Write property test for management route 403 enforcement
    - **Property 13: Management routes return 403 for non-admin/instructor users**
    - **Validates: Requirements 6.5**

- [ ] 5. Create Form Request classes
  - [ ] 5.1 Create `StoreCourseRequest` (`app/Http/Requests/StoreCourseRequest.php`)
    - Authorize instructor/admin, validate: `title` required string, `description` nullable, `thumbnail` nullable image, `price` numeric min:0, `difficulty` in:beginner,intermediate,advanced, `duration_minutes` integer min:0, `is_published` boolean
    - _Requirements: 6.1_
  - [ ] 5.2 Create `StoreChapterRequest` (`app/Http/Requests/StoreChapterRequest.php`)
    - Authorize instructor/admin, validate: `title` required string, `description` nullable
    - _Requirements: 6.2_
  - [ ] 5.3 Create `StoreLessonRequest` (`app/Http/Requests/StoreLessonRequest.php`)
    - Authorize instructor/admin, validate: `title` required string, `type` in:video,article,pdf,quiz, `duration_minutes` integer min:0, `content` nullable, `video_url` nullable url, `is_preview` boolean
    - _Requirements: 6.3_

- [ ] 6. Implement `EnrollmentService`
  - [ ] 6.1 Create `app/Services/EnrollmentService.php`
    - Implement `enroll(User $user, Course $course): Enrollment` using `firstOrCreate` on `[user_id, course_id]`
    - _Requirements: 4.2, 4.3_
  - [ ]* 6.2 Write property test for enrollment record creation
    - **Property 7: Enrollment creates a persisted record**
    - **Validates: Requirements 4.2**

- [ ] 7. Implement controllers
  - [ ] 7.1 Create `CourseController` (`app/Http/Controllers/CourseController.php`)
    - `index()`: query published courses with instructor eager-loaded, pass to `courses.index` view
    - `show($id)`: `findOrFail`, eager-load chapters.lessons, resolve `$enrolled` and `$completedLessonIds` for auth user, pass to `courses.show` view
    - `create()` / `edit($id)`: return form views
    - `store(StoreCourseRequest)`: create course with `instructor_id = auth()->id()`, redirect to `courses.show`
    - `update(StoreCourseRequest, $id)`: update course, redirect to `courses.show`
    - `destroy($id)`: delete course, redirect to `courses.index`
    - _Requirements: 1.1, 1.2, 1.3, 6.1_
  - [ ]* 7.2 Write property test for course detail page rendering
    - **Property 1: Course page renders all required fields**
    - **Validates: Requirements 1.1, 2.3**
  - [ ] 7.3 Create `ChapterController` (`app/Http/Controllers/ChapterController.php`)
    - `store(StoreChapterRequest, $courseId)`: auto-assign `display_order = chapter_count + 1`, create chapter, redirect back
    - `edit($id)` / `update(StoreChapterRequest, $id)` / `destroy($id)`: standard CRUD, redirect back
    - `reorder(Request, $courseId)`: accept ordered array of chapter IDs, update each `display_order`, return 200
    - _Requirements: 6.2, 6.4_
  - [ ]* 7.4 Write property test for display order persistence after reorder
    - **Property 12: Display order persists after reorder**
    - **Validates: Requirements 6.4**
  - [ ] 7.5 Create `LessonController` (`app/Http/Controllers/LessonController.php`)
    - `show($id)`: `findOrFail`, check `is_preview` or enrollment; redirect to login if guest on non-preview; pass enrollment prompt flag if authenticated but not enrolled; otherwise render `lessons.show`
    - `store(StoreLessonRequest, $chapterId)`: auto-assign `display_order = lesson_count + 1`, create lesson, redirect back
    - `edit($id)` / `update(StoreLessonRequest, $id)` / `destroy($id)`: standard CRUD, redirect back
    - `reorder(Request, $chapterId)`: accept ordered array of lesson IDs, update each `display_order`, return 200
    - _Requirements: 3.1, 3.2, 3.3, 3.4, 6.3, 6.4_
  - [ ]* 7.6 Write property test for lesson access control
    - **Property 5: Lesson access control by enrollment and preview status**
    - **Validates: Requirements 3.1, 3.2, 3.3, 3.4**
  - [ ] 7.7 Create `EnrollmentController` (`app/Http/Controllers/EnrollmentController.php`)
    - `store(Request, $courseId)`: call `EnrollmentService::enroll`, redirect to `courses.show` with success flash
    - _Requirements: 4.2, 4.3_
  - [ ] 7.8 Create `ProgressController` (`app/Http/Controllers/ProgressController.php`)
    - `store(Request, $lessonId)`: `firstOrCreate` on `[user_id, lesson_id]`, return 200 JSON or redirect back
    - _Requirements: 5.2_
  - [ ]* 7.9 Write property test for progress record idempotency
    - **Property 9: Marking a lesson complete creates a progress record**
    - **Validates: Requirements 5.2**

- [ ] 8. Checkpoint — ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 9. Register routes in `routes/web.php`
  - [ ] 9.1 Add public course browsing routes (no middleware)
    - `GET /courses` → `CourseController@index` (name: `courses.index`)
    - `GET /courses/show/{id}` → `CourseController@show` (name: `courses.show`)
    - _Requirements: 1.1, 1.2_
  - [ ] 9.2 Add authenticated student routes (middleware: `auth`)
    - `POST /courses/{courseId}/enroll` → `EnrollmentController@store` (name: `courses.enroll`)
    - `GET /lessons/{id}` → `LessonController@show` (name: `lessons.show`)
    - `POST /lessons/{id}/complete` → `ProgressController@store` (name: `lessons.complete`)
    - _Requirements: 3.1, 4.1, 5.2_
  - [ ] 9.3 Add instructor/admin management routes (middleware: `auth`, `instructor`)
    - Course CRUD: create, store, edit, update, destroy under `/courses` prefix
    - Chapter CRUD + reorder under `/chapters` prefix
    - Lesson CRUD + reorder under `/lessons` prefix
    - _Requirements: 6.1, 6.5_
  - [ ]* 9.4 Write feature test for management route 403 enforcement
    - Verify each management route returns 403 for a `user` role
    - **Property 13: Management routes return 403 for non-admin/instructor users**
    - **Validates: Requirements 6.5**

- [ ] 10. Build Blade views
  - [ ] 10.1 Create `resources/views/courses/index.blade.php`
    - Extend `master` layout, list published courses with title, thumbnail, instructor, price, difficulty
    - Show "Create Course" button for admin/instructor users
    - _Requirements: 6.1_
  - [ ] 10.2 Create `resources/views/courses/show.blade.php`
    - Extend `master` layout
    - Display course title, description, thumbnail, instructor name, price, difficulty, total duration (Req 1.1)
    - Display total chapter count and total lesson count (Req 1.3)
    - Render chapters in `display_order` with nested lessons in `display_order` (Req 2.1, 2.2)
    - Show lesson title, type badge, and duration for each lesson (Req 2.3)
    - Add "Preview" badge on lessons where `is_preview = true` (Req 2.4)
    - Show enroll button only when authenticated and not enrolled (Req 4.1, 4.4)
    - Show progress bar and completed lesson markers for enrolled students (Req 5.1, 5.3, 5.4)
    - Show edit/delete controls only for admin/instructor (Req 6.1)
    - _Requirements: 1.1, 1.3, 2.1, 2.2, 2.3, 2.4, 4.1, 4.4, 5.1, 5.3, 5.4, 6.1_
  - [ ]* 10.3 Write property test for course detail page HTML output
    - **Property 1: Course page renders all required fields**
    - **Property 4: Preview lessons are visually distinguished**
    - **Property 6: Enroll button visibility matches enrollment status**
    - **Property 8: Progress display accuracy**
    - **Property 10: Edit controls visible only to admin or instructor**
    - **Validates: Requirements 1.1, 2.4, 4.1, 4.4, 5.1, 5.3, 5.4, 6.1**
  - [ ] 10.4 Create `resources/views/courses/create.blade.php` and `edit.blade.php`
    - Extend `master` layout, render form with all course fields, validation error display
    - _Requirements: 6.1_
  - [ ] 10.5 Create `resources/views/chapters/_form.blade.php`
    - Inline form partial for creating/editing a chapter (title, description fields)
    - _Requirements: 6.2_
  - [ ] 10.6 Create `resources/views/lessons/show.blade.php`
    - Extend `master` layout, render lesson content (video player or article body)
    - Show enrollment prompt section when `$enrolled = false` and lesson is not preview
    - Show "Mark as Complete" button for enrolled students
    - _Requirements: 3.2, 3.3, 5.2_
  - [ ] 10.7 Create `resources/views/lessons/_form.blade.php`
    - Inline form partial for creating/editing a lesson (title, type, duration, content, video_url, is_preview fields)
    - _Requirements: 6.3_
  - [ ]* 10.8 Write property test for enroll button and progress indicator rendering
    - **Property 6: Enroll button visibility matches enrollment status**
    - **Property 8: Progress display accuracy**
    - **Validates: Requirements 4.1, 4.4, 5.1, 5.3, 5.4**

- [ ] 11. Final checkpoint — ensure all tests pass
  - Run `php artisan test` and confirm all feature and property tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for a faster MVP
- Each task references specific requirements for traceability
- Property tests use Pest PHP with pest-plugin-faker; each test runs a minimum of 100 iterations
- Each property test must include the comment: `// Feature: course-content-structure, Property {N}: {property_text}`
- The `instructor` middleware reuses the `isInstructorOrAdmin()` helper added to the `User` model
