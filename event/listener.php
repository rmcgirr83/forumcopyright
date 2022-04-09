<?php
/**
*
* Forum Copyright extension for the phpBB Forum Software package.
*
* @copyright (c) 2022 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\forumcopyright\event;

/**
* @ignore
*/
use phpbb\config\config;
use phpbb\language\language;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{

	/** @var config $config */
	protected $config;

	/** @var language $language */
	protected $language;

	/** @var template $template */
	protected $template;

	public function __construct(
		config $config,
		language $language,
		template $template)
	{
		$this->config = $config;
		$this->language = $language;
		$this->template = $template;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return [
			'core.acp_extensions_run_action_after'	=>	'acp_extensions_run_action_after',
			'core.page_footer'						=>	'page_footer',
		];
	}

	/* Display additional metdate in extension details
	*
	* @param $event			event object
	* @param return null
	* @access public
	*/
	public function acp_extensions_run_action_after($event)
	{
		if ($event['ext_name'] == 'rmcgirr83/forumcopyright' && $event['action'] == 'details')
		{
			$this->language->add_lang('common', $event['ext_name']);
			$this->template->assign_vars([
				'L_BUY_ME_A_BEER_EXPLAIN'		=> $this->language->lang('BUY_ME_A_BEER_EXPLAIN', '<a href="' . $this->language->lang('BUY_ME_A_BEER_URL') . '" target="_blank" rel="noreferrer noopener">', '</a>'),
				'S_BUY_ME_A_BEER_FC' => true,
			]);
		}
	}

	/**
	* Display forum copyright in footer
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function page_footer($event)
	{
		$this->language->add_lang('common', 'rmcgirr83/forumcopyright');

		$begin_year = date("Y",$this->config['board_startdate']);
		$current_year = '<script>var year=new Date(); year=year.getYear(); if (year<1900) year+=1900; document.write(year);</script>';

		// assign the forum stats to the template.
		$this->template->assign_vars([
			'FORUM_COPYRIGHT' => $this->language->lang('FORUM_COPYRIGHT'),
			'FORUM_BEGIN_YEAR' => $begin_year,
			'S_FORUM_COPYRIGHT' => true,
		]);
	}
}
