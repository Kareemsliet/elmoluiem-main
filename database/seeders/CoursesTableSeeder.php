<?php

namespace Database\Seeders;

use App\Enums\CourseLevelsEnums;
use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $frontEndCourse=Course::create([
            'title' => 'Frontend Development',
            'description' => 'HTML, CSS, JavaScript and frontend frameworks',
            'sub_category_id' => 1,
            "teacher_id"=>1,
            "level"=>CourseLevelsEnums::BEGINNER,
        ]);

        $contents=$frontEndCourse->contents()->createMany([
            [
                'title' => 'HTML Basics',
                'description' => 'Learn the structure of web pages using HTML.',
            ],
            [
                'title' => 'CSS Fundamentals',
                'description' => 'Style your web pages with CSS.',
            ],
            [
                'title' => 'JavaScript Essentials',
                'description' => 'Make your web pages interactive with JavaScript.',
            ],
            [
                'title' => 'Frontend Frameworks',
                'description' => 'Explore popular frontend frameworks like React and Vue.',
            ],
        ]);

        $contents->map(function($conten){
            $conten->lectures()->createMany([
                [
                    'title' => 'HTML Introduction',
                    'description' => 'Understanding the basics of HTML.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'CSS Selectors',
                    'description' => 'Learn about different CSS selectors.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'JavaScript Variables',
                    'description' => 'Understanding variables in JavaScript.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'React Components',
                    'description' => 'Learn about components in React.',
                    "video"=>"1077340382",
                ],
            ]);
        });

        $backEndCourse=Course::create([
            'title' => 'Backend Development',
            'description' => 'Server-side programming and database integration',
            'sub_category_id' => 2,
            "teacher_id"=>1,
            "level"=>CourseLevelsEnums::ADVANCED,
        ]);

        $contents=$backEndCourse->contents()->createMany([
            [
                'title' => 'Server-side Programming',
                'description' => 'Learn about server-side programming languages.',
            ],
            [
                'title' => 'Database Integration',
                'description' => 'Integrate databases with your backend applications.',
            ],
            [
                'title' => 'API Development',
                'description' => 'Create RESTful APIs for your applications.',
            ],
            [
                'title' => 'Authentication and Security',
                'description' => 'Implement authentication and security measures.',
            ],
        ]);

        $contents->map(function($conten){
            $conten->lectures()->createMany([
                [
                    'title' => 'Node.js Basics',
                    'description' => 'Understanding the basics of Node.js.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'Express.js Framework',
                    'description' => 'Learn about the Express.js framework.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'Database Management',
                    'description' => 'Understanding database management systems.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'API Security',
                    'description' => 'Learn about securing APIs.',
                    "video"=>"1077340382",
                ],
            ]);
        });

        $mobileDevelopmentCourse=Course::create([
            'title' => 'Mobile Development',
            'description' => 'Building apps for Android and iOS devices',
            'sub_category_id' => 3,
            "teacher_id"=>1,
            "level"=>CourseLevelsEnums::INTERMEDIATE,
        ]);

        $contents=$mobileDevelopmentCourse->contents()->createMany([
            [
                'title' => 'Android Development',
                'description' => 'Learn how to build apps for Android devices.',
            ],
            [
                'title' => 'iOS Development',
                'description' => 'Learn how to build apps for iOS devices.',
            ],
            [
                'title' => 'Cross-Platform Development',
                'description' => 'Build apps that work on both Android and iOS.',
            ],
            [
                'title' => 'Mobile App Design',
                'description' => 'Learn about designing user-friendly mobile apps.',
            ],
        ]);

        $contents->map(function($conten){
            $conten->lectures()->createMany([
                [
                    'title' => 'Android Studio Setup',
                    'description' => 'Setting up Android Studio for development.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'Swift Basics',
                    'description' => 'Understanding the basics of Swift programming.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'React Native Overview',
                    'description' => 'Learn about React Native for cross-platform development.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'Mobile App Testing',
                    'description' => 'Learn about testing mobile applications.',
                    "video"=>"1077340382",
                ],
            ]);
        });

        $dataScienceCourse=Course::create([
            'title' => 'Data Science',
            'description' => 'Explore data analysis, machine learning, and artificial intelligence techniques.',
            'sub_category_id' => 4,
            "teacher_id"=>1,
            "level"=>CourseLevelsEnums::EXPERT,
        ]);

        $contents=$dataScienceCourse->contents()->createMany([
            [
                'title' => 'Data Analysis',
                'description' => 'Learn how to analyze data using various tools.',
            ],
            [
                'title' => 'Machine Learning',
                'description' => 'Explore machine learning algorithms and techniques.',
            ],
            [
                'title' => 'Data Visualization',
                'description' => 'Learn how to visualize data effectively.',
            ],
            [
                'title' => 'Artificial Intelligence',
                'description' => 'Understand the basics of artificial intelligence.',
            ],
        ]);

        $contents->map(function($conten){
            $conten->lectures()->createMany([
                [
                    'title' => 'Python for Data Science',
                    'description' => 'Learn Python programming for data science.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'Machine Learning Algorithms',
                    'description' => 'Understanding various machine learning algorithms.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'Data Visualization Tools',
                    'description' => 'Learn about tools for data visualization.',
                    "video"=>"1077340382",
                ],
                [
                    'title' => 'AI Applications',
                    'description' => 'Explore applications of artificial intelligence.',
                    "video"=>"1077340382",
                ],
            ]);
        });

    }
}
