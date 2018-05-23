<?php

use Behat\Gherkin\Node\TableNode;
use Operator\Common\Infrastructure\Value\UuidGenerator;
use Operator\Common\Domain\Exception\InvalidArgumentException;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PostPublisher;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PublishPostCommand;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PublishPostCommandHandler;
use Voiceworks\Context\Post\Module\Post\Domain\Post;
use Voiceworks\Context\Post\Module\Post\Domain\WritePostRepository;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Persistence\WritePostRepositoryInMemory;

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
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

}
