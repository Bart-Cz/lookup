# Notes for Tech Test

I have made some assumptions to complete this tech task. Please see them below:
1. This is an existing project, so I have kept existing settings and tried not to upgrade anything, laravel 8 and PHP 8.1. 
2. I would normally install pest, but I have kept phpunit.
3. I usually work with larastan and pint, I have installed pint for styling check.
4. In real life scenario it would be probably more common to provide either id or username, 
but based on the existing code I have assumed that both can also be provided 
and instead of validating and throwing errors when both provided I believe it is a better UX if endpoints 
still return. There was a precedence in the existing code that I followed.
5. If the response from APIs does not follow what is expected it will throw.
6. There was no auth mentioned -> I have skipped it.
7. It seems to be an api endpoint, I would consider moving it to api.php, but if it is an existing project,
to avoid breaking changes, the endpoint is still in web.php
8. I have used sail for containerisation.
9. It seems to be a project that it is only calling APIs, so there might not be any need for mysql database,
but if it changes, some consideration should be given to tests and its settings e.g. RefreshDatabase etc.
I have not run migrations so hopefully nothing will break if run.

# Tebex Tech Test

## Submission

Please download/clone this repository and submit your final code by emailing a .zip or by sharing a link to your own repository on GitHub/GitLab. Please avoid forking this repository through GitHub.

## Task

### Part 1
Refactor the LookupController in this codebase. In particular, consider how Composition, Inheritance and Contracts can refactor this code in a clean, maintainable way.
Ensure that the final code follows PSR-12 standards (hint, some of it currently doesn't), and structure the code in a way that shows your knowledge of:

- SOLID principles
- OOP
- Contracts (Interfaces)
- Dependency Injection (In Laravel this also includes use of the Service Container)


### Part 2
Write some unit or feature tests for the code you've written. You do not need to have complete test coverage we just want to see that you have some experience in writing automated tests!

### Bonus Points

- Due to rate limits enforced by the underlying services, consider how data can be cached or persisted so that we're not having to call the underlying service every time
- Implement some 'defensive programming' (consider how and why the application might fail and implement appropriate precautions)
- Consider how error/fail states should be communicated back to the user

## Example Requests and expected Results:
(Note: This assumes the code is running on http://localhost:8000) - e.g. having been started using the built-in php server:

`php -S localhost:8000 -t public`

http://localhost:8000/lookup?type=xbl&username=tebex
```json
{"username":"Tebex","id":"2533274844413377","avatar":"https:\/\/avatar-ssl.xboxlive.com\/avatar\/2533274844413377\/avatarpic-l.png"}
```

http://localhost:8000/lookup?type=xbl&id=2533274884045330
```json
{"username":"d34dmanwalkin","id":"2533274884045330","avatar":"https:\/\/avatar-ssl.xboxlive.com\/avatar\/2533274884045330\/avatarpic-l.png"}
```

http://localhost:8000/lookup?type=steam&username=test
Should return an error "Steam only supports IDs"

http://localhost:8000/lookup?type=steam&id=76561198806141009
```json
{"username":"Tebex","id":"76561198806141009","avatar":"https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/c8\/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg"}
```

http://localhost:8000/lookup?type=minecraft&id=d8d5a9237b2043d8883b1150148d6955
```json
{"username":"Test","id":"d8d5a9237b2043d8883b1150148d6955","avatar":"https:\/\/crafatar.com\/avatarsd8d5a9237b2043d8883b1150148d6955"}
```

http://localhost:8000/lookup?type=minecraft&username=Notch
```json
{"username":"Notch","id":"069a79f444e94726a5befca90e38aaf5","avatar":"https:\/\/crafatar.com\/avatars069a79f444e94726a5befca90e38aaf5"}
```

