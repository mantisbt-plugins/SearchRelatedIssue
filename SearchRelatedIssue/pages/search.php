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


form_security_validate( 'bug_report' );

$t_temp_filter = filter_get_default();

$t_temp_filter[FILTER_PROPERTY_HIDE_STATUS] = META_FILTER_NONE;

$t_filter = filter_ensure_valid_filter( $t_temp_filter );

$t_filter['search'] = gpc_get_string( 'referal' );

$t_request_id = gpc_get_int( 'request_id' );

$t_current_project = helper_get_current_project();

$t_filter['project_id'][0] = $t_current_project;

$t_per_page   = null;
$t_bug_count  = null;
$t_page_count = null;

$t_rows = filter_get_bug_rows( $f_page_number, $t_per_page, $t_page_count, $t_bug_count, $t_filter, null, null, true );

$t_response['request_id'] = $t_request_id;
$t_response['data']       = '';

if( count( $t_rows ) > 0 ) {

    $t_response['data'] = '<ul class="search_result">';
    $t_response['data'] .= '<li style="margin-left: 5px; margin-top: 5px; margin-bottom: 5px;">' . sprintf( plugin_lang_get( 'header_related_issue_list' ), lang_get( 'issues' ) ) . '</li>';

    foreach( $t_rows as $t_issue ) {
        $t_response['data'] .= '<li>' .
                '<a class=search_result style="background-color:' . get_status_color( $t_issue->status ) . ';" href="' . string_get_bug_view_url( $t_issue->id ) . '";>' . $t_issue->id . ": " . $t_issue->summary . '</a></li>';
    }

    $t_response['data'] .= '</ul>';
}

$t_response_json = json_encode( $t_response );

echo $t_response_json;

