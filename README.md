# Laravel-SerializableModel
With this php class you can bind models to view forms.
Add this class to your laravel project, into the path 'app/Helpers' (you can customize it as you want).
You can use this class to auto inject models into laravel controllers' actions.
Add a form to your view and assign to your inputs, names congruent to properties of your model.

Example:
```
<form>
  <input type="textbox" name="email" />
  <input type="textbox" name="name" />
  <input type="password" name="password" />
</form>
```

The model will be defined as follow:

```
class UserModel{
  /*Extension*/
  use SerializableModel;

  /*Fields to serialize during transfer between View and Controller's action*/
  protected static $ToSerialize = ['name', 'password', 'email'];

  /*Fields*/
  public $name, $password, $email;

  /*!! Important !!*/
  /*You can't define a constructor ( cause it is already implemented by SerializableModel )*/
  /*But you can use other functions as constructor*/

  public function construct($data){ //construct not __construct
    /*operations*/
    return $this;
  }
}
```

Your controller will be defined as follow:

```
class DefaultController extends Controller
{
    public function action(User $user){
      /*$user will have all properties, specified by '$ToSerialize', filled*/
    }
}
```
