<?php
/**
 * @package    club
 *
 * @author     Admin <your@email.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://your.url.com
 */

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Database\DatabaseDriver;

defined('_JEXEC') or die;

/**
 * Club plugin.
 *
 * @package  club
 * @since    1.0
 */
class plgSystemClub extends CMSPlugin
{
	/**
	 * Application object
	 *
	 * @var    CMSApplication
	 * @since  1.0
	 */
	protected $app;

	/**
	 * Database object
	 *
	 * @var    DatabaseDriver
	 * @since  1.0
	 */
	protected $db;

	/**
	 * Affects constructor behavior. If true, language files will be loaded automatically.
	 *
	 * @var    boolean
	 * @since  1.0
	 */
	protected $autoloadLanguage = true;

	public function onBeforeRender(): void
    {
        $groupID = $this->params->get('group', 0);
        $groupBadID = $this->params->get('group_bad', 0);
        if (JFactory::getUser()->guest || $groupID === 0 || $groupBadID === 0) return;
        $userID = JFactory::getUser()->id;
        $userGroups = JUserHelper::getUserGroups($userID);
        $db =& JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
            ->select("max(`dat`) + interval 1 month as `is_club`")
            ->from("`#__payments`")
            ->where("`userID` = {$userID}")
            ->having("`is_club` > current_timestamp");
        $result = $db->setQuery($query)->loadResult();
        if ($result !== null) {
            if (!in_array($groupID, $userGroups)) {
                JUserHelper::addUserToGroup($userID, $groupID);
            }
            if (in_array($groupBadID, $userGroups)) {
                JUserHelper::removeUserFromGroup($userID, $groupBadID);
            }
        }
        else {
            if (in_array($groupID, $userGroups)) {
                JUserHelper::removeUserFromGroup($userID, $groupID);
            }
            if (!in_array($groupBadID, $userGroups)) {
                JUserHelper::addUserToGroup($userID, $groupBadID);
            }
        }
    }

	/**
	 * onAfterInitialise.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	public function onAfterInitialise()
	{
		
	}

	/**
	 * onAfterRoute.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	public function onAfterRoute()
	{
	
	}

	/**
	 * onAfterDispatch.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	public function onAfterDispatch()
	{
	
	}

	/**
	 * onAfterRender.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	public function onAfterRender()
	{
		// Access to plugin parameters
		$sample = $this->params->get('sample', '42');
	}

	/**
	 * onAfterCompileHead.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	public function onAfterCompileHead()
	{
	
	}

	/**
	 * OnAfterCompress.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	public function onAfterCompress()
	{
	
	}

	/**
	 * onAfterRespond.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	public function onAfterRespond()
	{
	
	}
}
