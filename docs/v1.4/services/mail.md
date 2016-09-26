The mail service acts as a bridge to all available mailers such as swift, mandrill, mailgun. Which supports a via smtp or api.


# Basic Usage

To send an email, you only need to call the facade `Mail` or helper `mail()`. A sample code below should show you on how to use it.

```php
$to = 'john@doe.com';
$subject = 'Confirm your registration';
$url = '<a generated url>';
Mail::send(
            'emails.registered-inlined',
            ['url' => $url],
            function ($mail) use ($to, $subject) {
                $mail->to([$to]);
                $mail->subject($subject);
            }
        );
```

