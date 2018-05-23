<?php

use Behat\Gherkin\Node\TableNode;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PostPublisher;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PublishPostCommand;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PublishPostCommandHandler;
use Voiceworks\Context\Post\Module\Post\Domain\Post;
use Operator\Common\Domain\Exception\InvalidArgumentException;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;
    use ConfigurationTrait;
    public $postId;
    public $postTitle;
    public $postContent;
    public $postAuthor;
    public $postTags;
    public $exception;
}
