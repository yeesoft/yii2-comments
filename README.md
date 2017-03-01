# yii2-comments

Comments module for Yii 2
=====

This module allows you to easy integrate comments system into your Yii2 application.


Installation
------------

- Either run

```
composer require --prefer-dist yeesoft/yii2-comments "~0.1.0"
```

or add

```
"yeesoft/yii2-comments": "~0.1.0"
```

to the require section of your `composer.json` file.

- Run migrations

```php
yii migrate --migrationPath=@vendor/yeesoft/yii2-comments/migrations/
```

Configuration
------

- In your config file

```php
'bootstrap' => ['comments'],
'modules'=>[
	'comments' => [
		'class' => 'yeesoft\comments\Comments',
	],
],
```

- In you model [optional]

```php
public function behaviors()
{
  return [
    'comments' => [
      'class' => 'yeesoft\comments\behaviors\CommentsBehavior'
    ]
  ];
}
```

- How to enable anti-spam protection (using Akismet) [optional]

```php
'modules' => [
	'comments' => [
		...
		 'enableSpamProtection' => true,
		 ...
	],
],
'components' => [
	'akismet' => [
            'class' => 'yeesoft\comments\components\Akismet',
            'apiKey' => '*******', //you can get your apiKey here: https://akismet.com/
	],
],
```

Usage
---

- Widget namespace
```php
use yeesoft\comments\widgets\Comments;
```

- Add comment widget in model view using (string) page key :

```php
echo Comments::widget(['model' => $pageKey]); 
```

- Or display comments using model name and id:

```php
echo Comments::widget(['model' => 'post', 'model_id' => 1]); 
```

- Or display comments using model behavior:

```php
echo Post::findOne(10)->displayComments(); 
```

Module Options
-------

Use this options to configurate comments module:
 
- `userModel` - User model class name.

- `maxNestedLevel` - Maximum allowed nested level for comment's replies.

- `onlyRegistered` - Indicates whether not registered users can leave a comment.

- `orderDirection` - Comments order direction.

- `nestedOrderDirection` - Replies order direction.

- `userAvatar` - The field for displaying user avatars.

  Is this field is NULL default avatar image will be displayed. Also it can specify path to image or use callable type.
  
  If this property is specified as a callback, it should have the following signature: `function ($user_id)`

  Example of module settings:
  ```php
    'comments' => [
      'class' => 'yeesoft\comments\Comments',
      'userAvatar' => function($user_id){
        return User::getUserAvatarByID($user_id);
      }
    ]
  ```
  
Screenshots
-------  

[Flickr - Yii2 Comments Module](https://www.flickr.com/photos/134050409@N07/sets/72157655976646912)
