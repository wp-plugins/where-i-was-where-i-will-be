WIWWIWB
=======

Where I Was, Where I Will Be [WP Plugin]

A Simple WP Plugin using Google Maps Api to show the places where you went!

|Attribute	            | Type      	        | Value if not set	    | Description           |
| :-------------------- | :-------------------- | :-------------------: | :-------------------- |
|start_date	            | Date (MM/DD/YYYY)	    | {EMPTY}		        | Show local that you visited since this date. |
|end_date	            | Date (MM/DD/YYYY)	    | {EMPTY}		        | Show local that you visit until this date. |
|only_until_today	    | True / False	        | False		            | Show local that you have visited until today. (if set as True, it will ignore the value in _end_date_) |
|type	                | Choose from a list	|                       | All itens	Show only selected types. |
|local	                | Choose from a list	|                       | All Itens	Show only selected locals. (if set, it will ignore the value in _type_ field.) |
|show_no_arrival	    | True / False	        | False		            | Show local if Start Date wasn’t set. |
|class	                | Text	                |	{EMPTY}		        | Map div class |
|width	                | Text	                |	100%		        | Map width |
|height	                | Text	                |	400px		        | Map height |
|map_id	                | Text	                |   map_{aleatory text)	| Map Id |
|zoom	                | Select	            |	AUTO	            | Initial zoom. If set as AUTO, it will show all locals (if there is only one local, it will show it with zoom = 10. If set as a number and there are more than on local, it will be ignored, except if you mark _force zoom_)
|force_zoom	            | True / False	        | False	                | Force zoom when zoom isn’t set as AUTO. _See zoom description._ |
|map_type	            | Select	            |	Road Map	        | Type of map |
|zoom_control	        | Select	            |	Disabled	        | Show zoom control on map. |
|zoom_position	        | Select	            |	TOP_LEFT	        | Position of zoom control on map. Field _zoom_control_ must be enabled. |
|control_style	        | Select	            |	Disabled	        | Style of control on map (manual zoom). |
|control_position	    | Select	            |	TOP_RIGHT	        | Position of control on map. Field _control_style_ must be enabled. |
|pan_control	        | Select	            |	Disabled	        | Show pan control on map (shown area). |
|pan_position	        | Select	            |	TOP_LEFT	        | Position of Pan position. Field _pan_control_ must be enabled. |
|scale_control	        | Select	            |	Disabled	        | Show scale. |
|streetview_control	    | Select	            |	Disabled	        | Show street view button on map. |
|streetview_position	| Select	            |	TOP_LEFT	        | Position of street view button on map. Field _streetview_control_ must be enabled. |
|center_button	        | Select	            |   Enabled	            | Show a button to show all local on map. |
|center_button_position	| Select	            |   BOTTOM_CENTER       | Position of Center Button. Field _center_button_ must be enabled. |

More about _Control Position_ on Google Maps: https://developers.google.com/maps/documentation/javascript/controls#ControlPositioning

More about _Map Types_ on Google Maps: https://developers.google.com/maps/documentation/javascript/maptypes#BasicMapTypes
