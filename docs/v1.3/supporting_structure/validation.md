We definitely have something we need to validate before executing script going to other 3rd party resources such as sql server.

We validate data to match our needs.

The class **Phalcon\Validation** will do the job; We have sample validation classes in our `project-name/components/Validation`


---


## Creating Class Validator

```php
...

class JustAnotherValidator extends Validator
{
    public function initialize()
    {
        $this->add('email', new PresenceOf([
            'message' => 'Email is required',
        ]));

        $this->add('email', new Email([
            'message' => 'Email is not valid',
        ]));

        $this->add('email', new Uniqueness([
            'model'   => User::class,
            'message' => 'Email already exist'
        ]));

        $this->add('password', new PresenceOf([
            'message' => 'Password is required',
        ]));

        $this->add('password', new Confirmation([
            'with'    => 'repassword',
            'message' => 'Password and Repeat Password must match',
        ]));

        $this->add('repassword', new PresenceOf([
            'message' => 'Repeat Password is required',
        ]));
    }
}
```

The above code uses ***PresenceOf***, ***Email***, ***Uniqueness*** and ***Confirmation***, those classes are validators that filters a value from your data.

Let's assume we have this kind of data 

```php
$data = [
    'email' => 'johndoe',
    'password' => '123qwe',
    'repassword' => 'qwe123',
];

# this throws error
# - email format error
# - password and repassword not match
$validator = new SomeValidator();
$validator->validate($data);
```

and we have this:

```php
$data2 = [
    'email' => 'johndoe@gmail.com',
    'password' => '123qwe',
    'repassword' => '123qwe',
];

# this is ok, but assuming we have existing 'johndoe@gmail.com', so this throws error
# - email exists
$validator = new SomeValidator();
$validator->validate($data2);
```


---


## Available Validators

The lists below are available and mostly used by several developers, you could use them as your reference.

| Name         | Explanation                                                                                                                                                      |
|--------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| PresenceOf   | Validates that a field's value is not null or empty string.                                                                                                      |
| Identical    | Validates that a field's value is the same as a specified value                                                                                                  |
| Email        | Validates that field contains a valid email format                                                                                                               |
| ExclusionIn  | Validates that a value is not within a list of possible values                                                                                                   |
| InclusionIn  | Validates that a value is within a list of possible values                                                                                                       |
| Regex        | Validates that the value of a field matches a regular expression                                                                                                 |
| StringLength | Validates the length of a string                                                                                                                                 |
| Between      | Validates that a value is between two values                                                                                                                     |
| Confirmation | Validates that a value is the same as another present in the data                                                                                                |
| Url          | Validates that field contains a valid URL                                                                                                                        |
| CreditCard   | Validates a credit card number                                                                                                                                   |


---


## Custom Validator

You can create your own validation class to extend more or to suit your needs.

```php

use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;
use Phalcon\Validation\ValidatorInterface;

class IpValidator extends Validator implements ValidatorInterface
{
    /**
     * Executes the validation
     *
     * @param Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(Validation $validator, $attribute)
    {
        $value = $validator->getValue($attribute);

        if (!filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {

            $message = $this->getOption('message');
            if (!$message) {
                $message = 'The IP is not valid';
            }

            $validator->appendMessage(new Message($message, $attribute, 'Ip'));

            return false;
        }

        return true;
    }
}
```

***Note:*** always use boolean to indicate that it is validated or not.
