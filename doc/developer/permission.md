#Permission

##Register new permissions
System will fire a `permissions.all` event when it need get all permissions, in the event handler you can add permissions to `permissions` object which passed to the handler function. 

The permissions object is a [ArrayObject][1], so you can use it like a array:

```
Event::listen('permissions.all', function($permissions)
{
    $permissions['user.create'] = 'Permission for create new user';
    //           permission code   permission description
});

```

[1]: http://php.net/manual/en/class.arrayobject.php