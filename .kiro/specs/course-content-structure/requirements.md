# Requirements Document

## Introduction

This feature introduces a Course Detail Page at `courses/show/{id}` for a Laravel application. A course has a hierarchical content structure: a Course contains many Chapters (Sections), and each Chapter contains many Lessons. The page is publicly visible for browsing, but lesson content is restricted to enrolled users. Admins and instructors manage course content. Users can track their progress through enrolled courses.

## Glossary

- **Course**: The top-level learning unit with metadata such as title, description, thumbnail, price, difficulty, and duration.
- **Chapter**: A grouping of lessons within a course, also referred to as a Section. Has a title, description, and display order.
- **Lesson**: An individual learning unit within a Chapter. Has a title, type (video, article, PDF, quiz), duration, display order, and a preview flag.
- **Instructor**: An authenticated user with the instructor role who can create and manage courses and their content.
- **Admin**: An authenticated user with the admin role who has full management access to all courses.
- **Student**: An authenticated user who can enroll in courses and access lesson content.
- **Enrollment**: A record linking a Student to a Course, granting access to non-preview lessons.
- **Progress**: A record tracking which lessons a Student has completed within an enrolled Course.
- **Course_Detail_Page**: The view rendered at `courses/show/{id}`.
- **Content_Controller**: The Laravel controller responsible for rendering the Course_Detail_Page.
- **Enrollment_Service**: The service responsible for creating and managing Enrollment records.

---

## Requirements

### Requirement 1: Display Course Information

**User Story:** As a visitor or student, I want to see the course details on the course page, so that I can decide whether to enroll.

#### Acceptance Criteria

1. WHEN a user navigates to `courses/show/{id}`, THE Course_Detail_Page SHALL display the course title, description, thumbnail image, instructor name, price, difficulty level, and total duration.
2. IF the course with the given `{id}` does not exist, THEN THE Content_Controller SHALL return a 404 response.
3. THE Course_Detail_Page SHALL display the total number of chapters and the total number of lessons in the course.

---

### Requirement 2: Display Course Content Structure

**User Story:** As a visitor or student, I want to see the full chapter and lesson outline, so that I know what the course covers.

#### Acceptance Criteria

1. THE Course_Detail_Page SHALL display all chapters belonging to the course in ascending display order.
2. THE Course_Detail_Page SHALL display all lessons within each chapter in ascending display order.
3. THE Course_Detail_Page SHALL display each lesson's title, type (video, article, PDF, or quiz), and duration.
4. THE Course_Detail_Page SHALL visually distinguish preview lessons from non-preview lessons.

---

### Requirement 3: Lesson Access Control

**User Story:** As a student, I want preview lessons to be accessible without enrollment, so that I can sample the course before committing.

#### Acceptance Criteria

1. WHEN an unauthenticated user attempts to access a non-preview lesson, THE Course_Detail_Page SHALL redirect the user to the login page.
2. WHEN an authenticated user who is not enrolled attempts to access a non-preview lesson, THE Course_Detail_Page SHALL display an enrollment prompt instead of the lesson content.
3. WHEN an authenticated user who is enrolled attempts to access any lesson, THE Content_Controller SHALL grant access to the lesson content.
4. THE Course_Detail_Page SHALL allow any user (authenticated or not) to view preview lessons without enrollment.

---

### Requirement 4: Enrollment

**User Story:** As a student, I want to enroll in a course from the course detail page, so that I can access all lesson content.

#### Acceptance Criteria

1. WHEN an authenticated student views a course they are not enrolled in, THE Course_Detail_Page SHALL display an enroll button.
2. WHEN an authenticated student submits the enrollment form, THE Enrollment_Service SHALL create an Enrollment record linking the student to the course.
3. WHEN enrollment is successful, THE Enrollment_Service SHALL redirect the student back to the Course_Detail_Page with a success message.
4. IF an authenticated student is already enrolled in the course, THEN THE Course_Detail_Page SHALL not display the enroll button.
5. WHEN an unauthenticated user clicks the enroll button, THE Course_Detail_Page SHALL redirect the user to the login page.

---

### Requirement 5: Progress Tracking

**User Story:** As an enrolled student, I want to see my progress through the course, so that I know which lessons I have completed.

#### Acceptance Criteria

1. WHILE a student is enrolled in a course, THE Course_Detail_Page SHALL display a progress indicator showing the percentage of lessons completed.
2. WHEN an enrolled student marks a lesson as complete, THE Progress tracker SHALL record the lesson completion for that student.
3. THE Course_Detail_Page SHALL visually mark each lesson that the enrolled student has already completed.
4. IF a student has not completed any lessons, THEN THE Course_Detail_Page SHALL display 0% progress.

---

### Requirement 6: Course and Content Management

**User Story:** As an admin or instructor, I want to manage courses, chapters, and lessons, so that I can keep course content up to date.

#### Acceptance Criteria

1. THE Course_Detail_Page SHALL display edit controls for course, chapter, and lesson records only to users with the admin or instructor role.
2. WHEN an admin or instructor creates a chapter, THE system SHALL assign a default display order equal to the current chapter count plus one.
3. WHEN an admin or instructor creates a lesson, THE system SHALL assign a default display order equal to the current lesson count within the chapter plus one.
4. WHEN an admin or instructor reorders chapters or lessons, THE system SHALL persist the updated display order values.
5. IF a user without the admin or instructor role attempts to access a course management route, THEN THE system SHALL return a 403 response.
