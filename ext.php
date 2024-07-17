<?php
/**
*
* Forum Copyright extension for the phpBB Forum Software package.
*
* @copyright (c) 2022 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\forumcopyright;

/**
* Extension class for custom enable/disable/purge actions
*/
class ext extends \phpbb\extension\base
{
	/**
	 * Enable extension if phpBB version requirement is met
	 *
	 * @return bool
	 * @access public
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');
		$allowed = (phpbb_version_compare($config['version'], '3.3', '>=')) ? true : false;
		return $allowed;
	}
}
