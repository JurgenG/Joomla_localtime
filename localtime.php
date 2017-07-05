<?php
/**
 * @package    localtime
 *
 * @author     Jurgen Gaeremyn <info@sjette.be>
 * @copyright  Copyright (C) 2017 Jurgen Gaeremyn. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://sjette.be
 */

defined('_JEXEC') or die;

/**
 * Localtime plugin.
 *
 * @package  localtime
 * @since    1.0
 */
class plgSystemLocaltime extends JPlugin
{
	/**
	 * Application object
	 *
	 * @var    JApplicationCms
	 * @since  1.0
	 */
	protected $app;

	/**
	 * Database object
	 *
	 * @var    JDatabaseDriver
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
		// Check that we are in the site application.
		if (JFactory::getApplication()->isClient('administrator'))
		{
			return true;
		}

		// Set the variables.
		$format = $this->params->get("format");
		$regex = "/{time ([[:digit:][:blank:]:+-]+)}/gU";
		$output = "<span class='time' title='YYY'>XXX</span>";

		//TODO: Regex replace accolade block with span block

		$document = JFactory::getDocument();
		$document->addScript("https://momentjs.com/downloads/moment.min.js");
		$document->addScriptDeclaration('
        jQuery(document).ready(function() {
            jQuery("span.time").each(function() {
                var myMoment = jQuery(this).text();
                jQuery(this).attr("title",myMoment);
                jQuery(this).html(getLocalTime({myMoment: myMoment}));
            });
        });


        function getLocalTime(parameters) {
            var myMoment = parameters.myMoment;
            var format = parameters.format;
            var myEpoch;

            // Checking if the time exists of a part date and a part time, or only time...
            var arrSplitSpaces = myMoment.split(" ");
            if (arrSplitSpaces.length < 2) {
                // Only time, no date.
                if(format == null) format = "HH:mm Z" ;
                myEpoch = timeToday2Epoch({timeString: myMoment, format: format});
            } else {
                // Date and time
                if(format == null) format = "YYYY-MM-DD HH:mm Z" ;
                myEpoch = timeAndDate2Epoch(myMoment, format);
            }
            return myEpoch
        }

        function timeAndDate2Epoch(dateString, format) {
            if(format==null) format="YYY-MM-DD HH:mm Z";
            var myMoment = new moment(dateString);
            return myMoment.format(format);
        }

        function timeToday2Epoch(parameters) {
            var timeString = parameters.timeString;
            var format = parameters.format;
            if(format == null) format = "HH:mm Z";
            var myDate = new moment().format("YYYY-MM-DD ") + timeString;
            return timeAndDate2Epoch(myDate, format);
        }
');
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
