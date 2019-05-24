/*
 # Copyright (c) 2018 brlumen (igflocal@gmail.com)
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
 */
var display_request = 0;
var current_request = 0;
var loading_img;
var summary_input;

$(document).ready(function () {

    $('[name=summary]').after('<li id="loader_area" style="list-style-type: none;" hidden=""><img id="loading_img" src="/plugin_file.php?file=SearchRelatedIssue/ajax-loader.gif"></li>');
    loading_img = document.getElementById('loader_area');

    summary_input = document.getElementsByName('summary')[0];
    var bug_report_token = document.getElementsByName('bug_report_token')[0];

    if (summary_input.value.length > 0) {
        search_request(summary_input.value, bug_report_token.value);
    }
    var current_timer = 0;
    $('[name=summary]').bind("input", function () {
        if (this.value.length > 0 && this.value.trim() != 0) {

            loading_img.removeAttribute('hidden');
            clearTimeout(current_timer);
            var search_string = this.value;
            var token = $('[name=bug_report_token]').val();
            current_timer = setTimeout(function () {
                search_request(search_string, token);
            }, 700);
        }

        if (summary_input.value.length < 1) {
            $(".search_result").remove();
        }
    })
});

function search_request(search_string, token) {
    current_request++;
    $.ajax({
        type: 'post',
        url: '/plugin.php?page=SearchRelatedIssue/search',
        data: {
            'referal': search_string,
            'bug_report_token': token,
            'request_id': current_request,
        },
        response: 'text',
        success: function (data, textStatus, jqXHR) {
            try {
                var response = JSON.parse(data);
                if (response['request_id'] > display_request) {
                    $(".search_result").remove();
                    $('[id=loader_area]').after(response['data']);
                    display_request = response['request_id'];
                }
            } catch (err) {
                console.log(err);
            }
            if (summary_input.value.length < 1) {
                $(".search_result").remove();
            }
            loading_img.setAttribute('hidden', '');
        }
    })
}


