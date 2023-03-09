<?php

declare(strict_types = 1);

namespace Tests\unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use Statistics\Builder\ParamsBuilder;
use Statistics\Calculator\AveragePostsPerUserPerMonth;
use Statistics\Dto\StatisticsTo;
use Statistics\Dto\paramsTo;
use Statistics\Enum\StatsEnum;
use SocialPost\Dto\SocialPostTo;

/**
 * Class AveragePostsPerMonthPerUserTest
 *
 * @package Tests\unit
 */
class AveragePostsPerMonthPerUserTest extends TestCase
{
    
    public function testNoPosts(): void
    {
        $start = new DateTime;
        $start->setDate(2023,01,01);
        $start->setTime(0,0,0);
        $end = new DateTime;
        $end->setDate(2023,02,28);
        $end->setTime(23,59,59);

        $params = new ParamsTo();
        $params->setStatName(StatsEnum::AVERAGE_POSTS_NUMBER_PER_USER_PER_MONTH);
        $params->setStartDate($start);
        $params->setEndDate($end);
        
        $calculator = new AveragePostsPerUserPerMonth();
        $calculator->setParameters($params);
        
         // Calculate average posts per user per month
        $result = $calculator->Calculate();
         
         // Check if the result is correct
         $this->assertInstanceOf(StatisticsTo::class, $result);
         $this->assertEquals(0, $result->getValue());
    }

    public function testOneUserOneMonthThreePosts(): void
    {
        $start = new DateTime;
        $start->setDate(2023,01,01);
        $start->setTime(0,0,0);
        $end = new DateTime;
        $end->setDate(2023,01,31);
        $end->setTime(23,59,59);

        $params = new ParamsTo();
        $params->setStatName(StatsEnum::AVERAGE_POSTS_NUMBER_PER_USER_PER_MONTH);
        $params->setStartDate($start);
        $params->setEndDate($end);
        
        $calculator = new AveragePostsPerUserPerMonth();
        $calculator->setParameters($params);
        // Create some posts
        $post1 = new SocialPostTo();
        $post1->setAuthorId('user1');
        $post1->setDate(new DateTime('2023-01-01')); 

        $post2 = new SocialPostTo();
        $post2->setAuthorId('user1');
        $post2->setDate(new DateTime('2023-01-15')); 


        $post3 = new SocialPostTo();
        $post3->setAuthorId('user1');
        $post3->setDate(new DateTime('2023-01-20')); 
    
        // Accumulate test data
         $calculator->accumulateData($post1);
         $calculator->accumulateData($post2);
         $calculator->accumulateData($post3);

        
         // Calculate average posts per user per month
        $result = $calculator->Calculate();
         
         // Check if the result is correct
         $this->assertInstanceOf(StatisticsTo::class, $result);
         $this->assertEquals(3, $result->getValue());
    }

    public function testOneUserTwoMonthsPosts(): void
    {
        $start = new DateTime;
        $start->setDate(2023,01,01);
        $start->setTime(0,0,0);
        $end = new DateTime;
        $end->setDate(2023,02,28);
        $end->setTime(23,59,59);

        $params = new ParamsTo();
        $params->setStatName(StatsEnum::AVERAGE_POSTS_NUMBER_PER_USER_PER_MONTH);
        $params->setStartDate($start);
        $params->setEndDate($end);
        
        $calculator = new AveragePostsPerUserPerMonth();
        $calculator->setParameters($params);
        // Create some posts
        $post1 = new SocialPostTo();
        $post1->setAuthorId('user1');
        $post1->setDate(new DateTime('2023-01-01')); 

        $post2 = new SocialPostTo();
        $post2->setAuthorId('user1');
        $post2->setDate(new DateTime('2023-02-15')); 

    
        // Accumulate test data
         $calculator->accumulateData($post1);
         $calculator->accumulateData($post2);
     
        
         // Calculate average posts per user per month
        $result = $calculator->Calculate();
         
         // Check if the result is correct
         $this->assertInstanceOf(StatisticsTo::class, $result);
         $this->assertEquals(1, $result->getValue());
    }
    public function testOneUserTwoMonthsThreePosts(): void
    {
        $start = new DateTime;
        $start->setDate(2023,01,01);
        $start->setTime(0,0,0);
        $end = new DateTime;
        $end->setDate(2023,02,28);
        $end->setTime(23,59,59);

        $params = new ParamsTo();
        $params->setStatName(StatsEnum::AVERAGE_POSTS_NUMBER_PER_USER_PER_MONTH);
        $params->setStartDate($start);
        $params->setEndDate($end);
        
        $calculator = new AveragePostsPerUserPerMonth();
        $calculator->setParameters($params);
        // Create some posts
        $post1 = new SocialPostTo();
        $post1->setAuthorId('user1');
        $post1->setDate(new DateTime('2023-01-01')); 

        $post2 = new SocialPostTo();
        $post2->setAuthorId('user1');
        $post2->setDate(new DateTime('2023-01-15')); 


        $post3 = new SocialPostTo();
        $post3->setAuthorId('user1');
        $post3->setDate(new DateTime('2023-02-20')); 
    
        // Accumulate test data
         $calculator->accumulateData($post1);
         $calculator->accumulateData($post2);
         $calculator->accumulateData($post3);

        
         // Calculate average posts per user per month
        $result = $calculator->Calculate();
         
         // Check if the result is correct
         $this->assertInstanceOf(StatisticsTo::class, $result);
         $this->assertEquals(1.5, $result->getValue());
    }


    public function testTwoUsersOneMonthPosts(): void
    {
        $start = new DateTime;
        $start->setDate(2023,01,01);
        $start->setTime(0,0,0);
        $end = new DateTime;
        $end->setDate(2023,01,31);
        $end->setTime(23,59,59);

        $params = new ParamsTo();
        $params->setStatName(StatsEnum::AVERAGE_POSTS_NUMBER_PER_USER_PER_MONTH);
        $params->setStartDate($start);
        $params->setEndDate($end);
        
        $calculator = new AveragePostsPerUserPerMonth();
        $calculator->setParameters($params);
        // Create some posts
        $post1 = new SocialPostTo();
        $post1->setAuthorId('user1');
        $post1->setDate(new DateTime('2023-01-01')); 

        $post2 = new SocialPostTo();
        $post2->setAuthorId('user2');
        $post2->setDate(new DateTime('2023-01-15')); 


        $post3 = new SocialPostTo();
        $post3->setAuthorId('user2');
        $post3->setDate(new DateTime('2023-01-20')); 
    
        // Accumulate test data
         $calculator->accumulateData($post1);
         $calculator->accumulateData($post2);
         $calculator->accumulateData($post3);

        
         // Calculate average posts per user per month
        $result = $calculator->Calculate();
         
         // Check if the result is correct
         $this->assertInstanceOf(StatisticsTo::class, $result);
         $this->assertEquals(1.5, $result->getValue());
    }

   
    public function testTwoUsersTwoMonthsPosts(): void
    {
        $start = new DateTime;
        $start->setDate(2023,01,01);
        $start->setTime(0,0,0);
        $end = new DateTime;
        $end->setDate(2023,02,28);
        $end->setTime(23,59,59);

        $params = new ParamsTo();
        $params->setStatName(StatsEnum::AVERAGE_POSTS_NUMBER_PER_USER_PER_MONTH);
        $params->setStartDate($start);
        $params->setEndDate($end);
        
        $calculator = new AveragePostsPerUserPerMonth();
        $calculator->setParameters($params);
        // Create some posts
        $post1 = new SocialPostTo();
        $post1->setAuthorId('user1');
        $post1->setDate(new DateTime('2023-01-01')); 

        $post2 = new SocialPostTo();
        $post2->setAuthorId('user2');
        $post2->setDate(new DateTime('2023-01-15')); 


        $post3 = new SocialPostTo();
        $post3->setAuthorId('user2');
        $post3->setDate(new DateTime('2023-02-20')); 
    
        // Accumulate test data
         $calculator->accumulateData($post1);
         $calculator->accumulateData($post2);
         $calculator->accumulateData($post3);

        
         // Calculate average posts per user per month
        $result = $calculator->Calculate();
         
         // Check if the result is correct
         $this->assertInstanceOf(StatisticsTo::class, $result);
         $this->assertEquals(0.75, $result->getValue());
    }

 
    public function testPostOutsideDates(): void
    {
        $start = new DateTime;
        $start->setDate(2023,01,01);
        $start->setTime(0,0,0);
        $end = new DateTime;
        $end->setDate(2023,02,28);
        $end->setTime(23,59,59);

        $params = new ParamsTo();
        $params->setStatName(StatsEnum::AVERAGE_POSTS_NUMBER_PER_USER_PER_MONTH);
        $params->setStartDate($start);
        $params->setEndDate($end);
        
        $calculator = new AveragePostsPerUserPerMonth();
        $calculator->setParameters($params);
        // Create some posts
        $post1 = new SocialPostTo();
        $post1->setAuthorId('user1');
        $post1->setDate(new DateTime('2023-01-01')); 

        $post2 = new SocialPostTo();
        $post2->setAuthorId('user1');
        $post2->setDate(new DateTime('2023-01-15')); 


        $post3 = new SocialPostTo();
        $post3->setAuthorId('user1');
        $post3->setDate(new DateTime('2023-03-20')); 
    
        // Accumulate test data
         $calculator->accumulateData($post1);
         $calculator->accumulateData($post2);
         $calculator->accumulateData($post3);

        
         // Calculate average posts per user per month
        $result = $calculator->Calculate();
         
         // Check if the result is correct
         $this->assertInstanceOf(StatisticsTo::class, $result);
         $this->assertEquals(1, $result->getValue());
    }


    public function testFail(): void
    {
        //always fail
        $this->assertTrue(false);
    }
}