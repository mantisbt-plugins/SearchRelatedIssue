<?php

# Copyright (c) 2019 brlumen (igflocal@gmail.com)
# SearchRelatedIssue for MantisBT is free software: 
# you can redistribute it and/or modify it under the terms of the GNU
# General Public License as published by the Free Software Foundation, 
# either version 2 of the License, or (at your option) any later version.
#
# SearchRelatedIssue plugin for for MantisBT is distributed in the hope 
# that it will be useful, but WITHOUT ANY WARRANTY; without even the 
# implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
# See the GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with SearchRelatedIssue plugin for MantisBT.  
# If not, see <http://www.gnu.org/licenses/>.

class SearchRelatedIssuePlugin extends MantisPlugin {

    public function register() {
        $this->name        = 'SearchRelatedIssue';
        $this->description = plugin_lang_get( 'description' );

        $this->version  = '1.0.0';
        $this->requires = array(
                                  'MantisCore' => '2.0.0',
        );

        $this->author  = 'brlumen';
        $this->contact = 'igflocal@gmail.com';
        $this->url     = 'http://github.com/mantisbt-plugins/SearchRelatedIssue';
//        $this->page    = 'config_page';
    }

    function hooks() {
        return array(
                                  'EVENT_LAYOUT_RESOURCES' => 'resources',
        );
    }

    function resources() {

        $t_page = array_key_exists( 'REQUEST_URI', $_SERVER ) ? basename( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) ) : basename( __FILE__ );
        if( $t_page == 'bug_report_page.php' ) {
            return '<link rel="stylesheet" type="text/css" href="' . plugin_file( 'related_search_240520191349.css' ) . '"></link>' .
                    '<script type="text/javascript" src="' . plugin_file( 'related_search.js' ) . '"></script>';
        }
    }

}
