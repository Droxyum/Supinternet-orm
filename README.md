# supinternet-orm

`composer require droxyum/supinternet-orm dev-master`

---
 #### Create new connection to database: 
 `$Connection = new \ORM\Connection(host, database, username, password);`
 
 #### Create new EntityManager: 
 `$EntityManager = new \ORM\Entity\Manager();`
 
---
### Create new Entity "Post":

```
class Post extends Entity {
    const TABLE = 'posts';  //Table name
	protected $id; //Id field (primary key)
	protected $title; //Title field
	protected $content; //Content field
	
	public function setId($id) { 
		$this->id = $id;
	} 
 
	public function getId() { 
		return $this->id;
	} 
 
	public function setTitle($title) { 
		$this->title = $title;
	} 
 
	public function getTitle() { 
		return $this->title;
	} 
 
	public function setContent($content) { 
		$this->content = $content;
	} 
 
	public function getContent() { 
		return $this->content;
	} 

}
```

### Insert new post:
```
$Post = new \Entity\Post(); //New post
$Post->setTitle('My post title'); //Insert title
$Post->setContent('My post content'); //Insert content
$EntityManager->persist($Post); //Insert post in database
```

### Update post:
```
$Post = new \Entity\Post(); //New post
$Post->setId(5); //Insert post's id
$Post->setTitle('New post title'); //Insert new title
$Post->setContent('New post content'); //Insert new content
$EntityManager->persist($Post); //Update post in database
```

### Remove post
```
$Post = new \Entity\Post(); //New post
$Post->setId(5); //Insert post's id
$EntityManager->remove($Post); //Update post in database
```

### Find post
```
$PostsRepository = $EntityManager->getRepository('Entity:Post'); //Get post repository
$PostsRepository->findAll(); //Find all post in database
```

### Find with relationship
```
// New entity
//Category.php
class Category extends Entity 
{ 
	const TABLE = 'categories'; 
	protected $id; 
	protected $name; 
 
 
	public function setId($id) { 
		$this->id = $id;
	} 
 
	public function getId() { 
		return $this->id;
	} 
 
	public function setName($name) { 
		$this->name = $name;
	} 
 
	public function getName() { 
		return $this->name;
	} 
 
}

// Entity post created (Juste NanyToOne relation is available)
//Post.php
class Post extends Entity {
    // ...
    protected $Categories; 	 // Join field on \Entity\Category
    public function __construct() {
        $this->Categories = new ManyToOne($this, '\Entity\Categories'); //
    }
    // ...
}

//index.php
$PostsRepository = $EntityManager->getRepository('Entity:Post'); //Get post repository

//Find all post in database with relationship
///!\ 'doRelations' must be an array 
$PostsRepository->findAll(['doRelations' =>  ['Category'] ]);
```

---

### Create new methode in repository
```
class PostRepository extends Repository { } 
```

### Add new methode count
```
public function count($params = [])
{
    $Select = new Select(); //New Select request
    $entity = $this->Entity; /Get current entity
    $sql = $Select->select($this->Entity->getAlias())->from($entity::TABLE)->toSql(); //Select all fiels, from current entity (use table name with '$entity::TABLE') and get sql request

    $executeParams = [
        'type' => 'SELECT', //Specify request type
        'sql' => $sql, //Specify sql request
        'fn' => 'Count' //Return function 'count'
    ];

    //To do relationship if they are specify in $params
    if(!empty($params['doRelations']) && is_array($params['doRelations'])) {
        $executeParams['doRelations'] = $params['doRelations'];
    }
    
    //Return result of query (return 'fn' returning if isn't null or false)
    return QueryBuilder::execute($executeParams);
}
```

### $execureParams parameters:
- type: `SELECT, UPDATE, REMOVE`
- fn: `Exist (return true or false), Count (return number of rows)`

### QueryBuilding:
/!\ Methodes can be chainned
- `$Select = New Select; //Request type select`
- `$Update = New Update; //Request type select`
- `$Insert = New Insert; //Request type insert`
- `$Remove = New Remove; //Request type remove`
- For more information -> check source code at \Orm\QueryBuilder\