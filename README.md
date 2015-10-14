# HowdyBarber
An analysis tool to pick the best time to visit my barber

## Intro
My barber is way too **popular**. Every time after I visited him, his schedule will be full again. And I have to check regularly to book my next appointment. That bothers me a lot. Since my barber uses https://resurva.com for reservation, I took a look at their requests to their server when I did booking. Surprizingly they didn't use any authentation method for those API endpoints. I found ``https://handcraftedbarbershop.resurva.com/index/availability`` for avalibity checking. What's better is that it could return JSON as response. So I made this script and set up daily cronjob, and then I just need to wait for the text message remind me of the date for making the rerservation.

https://medium.com/@soleoshao/howdybarber-a-scripting-way-to-check-my-barber-s-availability-a75a22bcba0d

## Run
```
$ php howdy_barber.php
2015-11-04 1530, 2015-11-05 1130, 2015-11-05 1430, 2015-11-05 1445, 2015-11-05 1500, 2015-11-05 1515, 2015-11-05 1615, 2015-11-05 1630 Crawled at 10-12 03:10
```

## CronJob
Run everyday at 11 AM
```
0 11 * * * php /home/howdy_barber.php >> /dev/null
```
