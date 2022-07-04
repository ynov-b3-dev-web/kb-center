# Voter SF b3

Voters are Symfony's most powerful way of managing permissions. They allow you to centralize all permission logic, then reuse them in many places.

Create file `/src/Security/YourBestVoter.php`. Or you can easily use `make:voter` (depend of: Symfony MakerBundle)

In this file you can create the class like that:
```
class YourBestVoter extends Voter {


}
```

You will need to implement to methods: supports and voteOnAttribute
```
protected function supports(string $attribute, $subject): bool
{
	// $attribute contains your parameter send by is_granted method
	// only vote on `Post` objects
	if (!$subject instanceof Post) {
		return false;
	}

	return true;
}

protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
{
	$user = $token->getUser();

	// the user must be logged in; if not, deny access
	if (!$user instanceof User) {
		return false;
	}
	
	if($subject->getUser() !== $user)
		return false;
	return true;
}

```

## Explanation

The methods `supports` is used for validate the request. If the return is false, the return code will be 401 Access denied. 
If true is returned, you go on the method `voteOnAttribute`. Then this method has the same comportment, if false is returned, the response code will be 401 Access denied. But if true is returned, the response code will be 200 with your wanted data.
This comportment is only in the case of one Voter.
You can have many Voters and differents strategies of access.
See more on: https://symfony.com/doc/5.4/security/voters.html#changing-the-access-decision-strategy


## Your entity

Here is your entity Post
```
/**
 * @ApiResource(
 *     itemOperations={
 *          "get"={
 *             "access_control"="is_granted('something', previous_object)"
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post {

	**
 	* @ORM\Column(type="string", length=255)
	*/
	private $name;
	
	/**
	* @ORM\ManyToOne(targetEntity=User::class, inversedBy="Post")
	*/
	private $user;
}
```

You can see the access line `"access_control"="is_granted('something', object)"` which will call the controller .

## Another way

You can do the same thing in one line:
`access_control"="object.getAthlete() == user`

Thanks for reading.
