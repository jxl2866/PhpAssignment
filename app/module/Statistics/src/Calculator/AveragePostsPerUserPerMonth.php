<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class AveragePostsPerUserPerMonth extends AbstractCalculator
{

    protected const UNITS = 'posts';
    /*
        different unit for monthly breakdown of posts per user
        protected const UNITS = 'posts per user';
    */

    /**
     * @var array
     */
    private $postsByMonth = [];

     /**
     * @var array
     */
    private $uniqueUsers = [];

    
   
    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        /*
            TODO: Maybe set date format string as a constant for more flexibility
            maintained hardcoded format to adhere to coding style of other classes 
        */
         // track number of posts per month 
        $key = $postTo->getDate()->format('F Y');
        /* 
            I personally prefer this style as I find it more readable 
            Maintained style as other classes
                $this->postsByMonth[$key] ??= 0;
                $this->postsByMonth[$key]++;
        */
        $this->postsByMonth[$key] = ($this->postsByMonth[$key] ?? 0) + 1;

    
        /*
            TODO: Verify requirement on how to handle if getAuthorId() returns null
            for now, set as empty string -- All users without id would be counted as 1 user
            for example could potentially use author name if ID doesn't exist
        */

        // Keep track of unique users per month 
        $userId = $postTo->getAuthorId() !== null ? $postTo->getAuthorId() : '';
        $this->uniqueUsers[$key][$userId] = true;
    }

    /** 
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
       
       
    /*      $stats = new StatisticsTo();
       
     
       // Monthly breakdown of average posts per user
       // TODO: verify how far to round 
        foreach ($this->postsByMonth as $splitPeriod => $total) {
            $uniqueUsers = isset($this->uniqueUsers[$splitPeriod]) ? count($this->uniqueUsers[$splitPeriod]) : 0;
            $averageUserPostsPerMonth = $uniqueUsers !== 0 ? $total / $uniqueUsers : $total;
           
            $child = (new StatisticsTo())
                ->setName($this->parameters->getStatName())
                ->setSplitPeriod($splitPeriod)
                ->setValue($averageUserPostsPerMonth)
                ->setUnits(self::UNITS);

            $stats->addChild($child);
        }
        return $stats;
       */

        //Average posts per user per month 
        /*
            The commented out section of code is from my original interpretation or the prompt
            Where the average posts per user per month was a monthly breakdown of average posts per user
            Ideally I would have had these requirements clarified prior to working on this task
            It could have also been interpreted as a breakdown of users and their average posts per month 
            I decided to leave the doAccumulate() function as is so both implementations would work
            If this was the intended implementation, I would have created a simple array of unique user id's
            rather than merge all of the values of userID in the associated array and then look for the unique ids
            additional assumptions - include handling of 0 months and unique user counts
            currently treating the 0's as 1 month and 1 user if arrays are empty  
          
            Again I generally would prefer to not use ternary operators and would prefer to use if statements 
            but I wanted to adhere to the coding style of other classes in this project
        */
        $totalPosts = count($this->postsByMonth) > 0 ? array_sum($this->postsByMonth) : 0;
        $totalMonths = count($this->postsByMonth) > 0 ? count($this->postsByMonth) : 1;
        $allUsers = array_merge(...array_values($this->uniqueUsers));
        $uniqueUserCount = count($allUsers) > 0 ? count($allUsers) : 1;
        $averageUserPostsPerMonth = round($totalPosts/$uniqueUserCount/$totalMonths,2); //TODO: verify how to round
        return (new StatisticsTo())->setValue($averageUserPostsPerMonth);
    }
    
}
