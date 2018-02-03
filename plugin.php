<?php

class pluginNavigation extends Plugin {

	public function init()
	{
		// Fields and default values for the database of this plugin
		$this->dbFields = array(
			'label'=>'Menu',
			'display'=>true
		);
	}

	// Method called on the settings of the plugin on the admin area
	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<label>'.$Language->get('Label').'</label>';
		$html .= '<input id="jslabel" name="label" type="text" value="'.$this->getValue('label').'">';
		$html .= '<span class="tip">'.$Language->get('This title is almost always used in the sidebar of the site').'</span>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$Language->get('Display').'</label>';
		$html .= '<select name="display">';
		$html .= '<option value="true" '.($this->getValue('display')===true?'selected':'').'>'.$Language->get('Show subpages').'</option>';
		$html .= '<option value="false" '.($this->getValue('display')===false?'selected':'').'>'.$Language->get('Hide subpages').'</option>';
		$html .= '</select>';
		$html .= '</div>';

		return $html;
	}

	// Method called on the sidebar of the website
	public function siteSidebar()
	{
		global $Language;
		// global $dbPages;
		global $pagesByParent;
		global $Url;

		// HTML for sidebar
		$html  = '<div class="plugin plugin-menu">';

		// Print the label only if not empty
		if( $this->getValue('label') ) {
			$html .= '<h2 class="plugin-label">'.$this->getValue('label').'</h2>';
		}

		$html .= '<div class="plugin-content">';
		$html .= '<ul class="menu">';

        // Foreach parent-page
		foreach ( $pagesByParent[PARENT] as $Parent ){
			$html .= '<li class="menu"><a href="'.$Parent->permalink().'">'.$Parent->title().'</a></li>';

			// Check if the parent has sub-pages/children, and if they are dsiplayed

            if ( !empty($pagesByParent[$Parent->key()]) && $this->getValue('display') == 'true' ) {
				$html.= '<ul>';
				foreach ($pagesByParent[$Parent->key()] as $Child) {
					$html.= '<li class="menu"><a href="'.$Child->permalink().'">'.$Child->title().'</li>';
	        	}
				$html.= '</ul>';
			}

		}

		$html .= '</ul>';
 		$html .= '</div>';
 		$html .= '</div>';

		return $html;
	}
}
