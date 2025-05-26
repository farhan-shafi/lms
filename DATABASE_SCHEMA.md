# EduLearn LMS Database Schema Reference

This document provides a detailed overview of the database schema for the EduLearn LMS platform.

## Database Tables Overview

### Users

**Table: `users`**

- Central user management table storing all user data
- Key fields:
  - `id`: Unique identifier
  - `name`: Full name
  - `email`: Email address (unique)
  - `password`: Hashed password
  - `role`: User role (admin, instructor, student)
  - `profile_image`: Path to profile image
  - `status`: Account status (active, inactive, suspended)

### Course Organization

**Table: `categories`**

- Organizes courses into subject categories
- Key fields:
  - `id`: Unique identifier
  - `name`: Category name
  - `icon`: Category icon class (Font Awesome)
  - `slug`: URL-friendly name

**Table: `courses`**

- Stores all course information
- Key fields:
  - `id`: Unique identifier
  - `title`: Course title
  - `slug`: URL-friendly title
  - `description`: Course description
  - `instructor_id`: References users.id
  - `category_id`: References categories.id
  - `price`: Course price
  - `is_free`: Flag for free courses
  - `level`: Difficulty level
  - `status`: Course status (draft, published, archived)

**Table: `modules`**

- Sections/chapters within courses
- Key fields:
  - `id`: Unique identifier
  - `course_id`: References courses.id
  - `title`: Module title
  - `order`: Display order in course

**Table: `lessons`**

- Individual learning units within modules
- Key fields:
  - `id`: Unique identifier
  - `module_id`: References modules.id
  - `title`: Lesson title
  - `type`: Content type (video, document, text, audio, link)
  - `content`: Text content
  - `video_url`: Video URL for video lessons
  - `duration`: Length in seconds
  - `is_free`: Preview availability flag

### Assessment System

**Table: `quizzes`**

- Tests attached to course modules
- Key fields:
  - `id`: Unique identifier
  - `module_id`: References modules.id
  - `title`: Quiz title
  - `time_limit`: Time allowed in minutes
  - `passing_percentage`: Required score to pass

**Table: `quiz_questions`**

- Questions within quizzes
- Key fields:
  - `id`: Unique identifier
  - `quiz_id`: References quizzes.id
  - `question`: The question text
  - `type`: Question type (multiple_choice, true_false, short_answer, matching)
  - `points`: Point value

**Table: `quiz_answers`**

- Answer options for quiz questions
- Key fields:
  - `id`: Unique identifier
  - `question_id`: References quiz_questions.id
  - `answer_text`: Answer text
  - `is_correct`: Flag for correct answers

### Progress Tracking

**Table: `enrollments`**

- Records of student enrollments in courses
- Key fields:
  - `id`: Unique identifier
  - `user_id`: References users.id
  - `course_id`: References courses.id
  - `status`: Enrollment status (active, completed, dropped)
  - `progress`: Completion percentage
  - `completed_lessons`: Count of completed lessons
  - `enrollment_date`: Date of enrollment
  - `completion_date`: Date of completion

**Table: `progress_tracking`**

- Detailed tracking of student progress
- Key fields:
  - `id`: Unique identifier
  - `enrollment_id`: References enrollments.id
  - `lesson_id`: References lessons.id
  - `quiz_id`: References quizzes.id
  - `status`: Progress status (not_started, in_progress, completed)
  - `time_spent`: Time spent in seconds

**Table: `quiz_attempts`**

- Records of student quiz attempts
- Key fields:
  - `id`: Unique identifier
  - `user_id`: References users.id
  - `quiz_id`: References quizzes.id
  - `score`: Score achieved
  - `status`: Attempt status (pass, fail, incomplete)
  - `start_time`: Start timestamp
  - `end_time`: End timestamp

**Table: `quiz_responses`**

- Individual student answers to quiz questions
- Key fields:
  - `id`: Unique identifier
  - `attempt_id`: References quiz_attempts.id
  - `question_id`: References quiz_questions.id
  - `answer_id`: References quiz_answers.id
  - `text_response`: Free text response
  - `is_correct`: Correctness flag
  - `points_earned`: Points awarded

### Communication & Feedback

**Table: `course_reviews`**

- Student reviews of courses
- Key fields:
  - `id`: Unique identifier
  - `course_id`: References courses.id
  - `user_id`: References users.id
  - `rating`: Numerical rating
  - `review`: Text review
  - `status`: Review status (pending, approved, rejected)

**Table: `discussions`**

- Course discussion threads
- Key fields:
  - `id`: Unique identifier
  - `course_id`: References courses.id
  - `user_id`: References users.id
  - `title`: Discussion title
  - `message`: Discussion content
  - `status`: Thread status (active, closed, hidden)

**Table: `discussion_replies`**

- Replies to discussion threads
- Key fields:
  - `id`: Unique identifier
  - `discussion_id`: References discussions.id
  - `user_id`: References users.id
  - `message`: Reply content
  - `is_solution`: Solution flag

**Table: `announcements`**

- Course announcements from instructors
- Key fields:
  - `id`: Unique identifier
  - `course_id`: References courses.id
  - `user_id`: References users.id (instructor)
  - `title`: Announcement title
  - `message`: Announcement content

### Certification

**Table: `certificates`**

- Course completion certificates
- Key fields:
  - `id`: Unique identifier
  - `user_id`: References users.id
  - `course_id`: References courses.id
  - `certificate_number`: Unique certificate ID
  - `issue_date`: Date of issuance
  - `file_path`: Path to certificate file

### System Configuration

**Table: `settings`**

- System-wide configuration settings
- Key fields:
  - `id`: Unique identifier
  - `setting_key`: Setting name
  - `setting_value`: Setting value

## Relationships

### One-to-Many Relationships

- A user can create many courses (as instructor)
- A user can enroll in many courses (as student)
- A category can contain many courses
- A course can have many modules
- A module can have many lessons
- A module can have many quizzes
- A quiz can have many questions
- A question can have many answers
- A course can have many reviews
- A course can have many discussions
- A discussion can have many replies

### Many-to-Many Relationships

- Users and Courses (through enrollments)
- Users and Quizzes (through quiz_attempts)

## Database Diagram

For a visual representation of the database schema and relationships, you can generate an ER diagram using tools like MySQL Workbench, phpMyAdmin, or online tools like dbdiagram.io.

## Important Notes

1. **Cascading Deletes**:

   - Most child records are set to CASCADE on delete from parent records
   - Example: Deleting a course will delete all its modules, lessons, etc.

2. **Timestamps**:

   - Most tables include `created_at` and `updated_at` fields
   - `updated_at` fields use the `ON UPDATE CURRENT_TIMESTAMP` functionality

3. **Indexing Strategy**:

   - Foreign keys are indexed for performance
   - Frequently queried columns are indexed

4. **Data Validation**:
   - Primary validation happens at the application level
   - Database provides secondary validation through constraints
