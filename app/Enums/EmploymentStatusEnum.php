<?php

namespace App\Enums;

enum EmploymentStatusEnum : string
{
    case REGULAR = 'regular';
    case PROBATIONARY = 'probationary';
    case CONTRACTUAL = 'contractual';
    case CASUAL = 'casual';
    case TEMPORARY = 'temporary';
    case PROJECT_BASED = 'project-based';
    case SEASONAL = 'seasonal';
    case PART_TIME = 'part-time';
    case FULL_TIME = 'full-time';
    case APPRENTICE = 'apprentice';
    case CONSULTANT = 'consultant';
    case INTERN = 'intern';

    // Optional: You can add methods to get a description or other utilities
    public function getDescription(): string
    {
        return match($this) {
            self::REGULAR => 'The employee has completed any required probationary period and has been granted a permanent position.',
            self::PROBATIONARY => 'The employee is in a trial period, where their performance is evaluated before being considered for regular employment.',
            self::CONTRACTUAL => 'The employee is hired for a specific project or period under a fixed-term contract.',
            self::CASUAL => 'The employee is hired on an as-needed basis, often without a guarantee of regular hours.',
            self::TEMPORARY => 'The employee is hired for a short-term period, typically to cover for another employee or during busy times.',
            self::PROJECT_BASED => 'The employee is hired for a specific project with the understanding that employment will end once the project is completed.',
            self::SEASONAL => 'The employee works during certain seasons or times of the year when additional staff is needed.',
            self::PART_TIME => 'The employee works fewer hours than full-time employees, often with pro-rated benefits.',
            self::FULL_TIME => 'The employee works the standard number of hours as defined by the company and is entitled to full benefits.',
            self::APPRENTICE => 'The employee is undergoing training or learning a trade, usually under a fixed-term agreement.',
            self::CONSULTANT => 'An individual who works independently and may offer services to multiple clients.',
            self::INTERN => 'A student or recent graduate who works to gain experience in a specific field.',
        };
    }
}
