#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	table_content text,
	visibility tinyint(4) unsigned DEFAULT '0' NOT NULL
	image_shape tinyint(4) unsigned DEFAULT '0' NOT NULL
	image_responsive tinyint(4) unsigned DEFAULT '1' NOT NULL,
	gallery_width tinyint(4) DEFAULT '0' NOT NULL,
	gallery_break tinyint(4) unsigned DEFAULT '0' NOT NULL,
	gallery_carousel tinyint(4) unsigned DEFAULT '0' NOT NULL,
	header_position tinyint(4) unsigned DEFAULT '0' NOT NULL
	header_style tinyint(4) unsigned DEFAULT '0' NOT NULL
	header_icon varchar(60) DEFAULT '' NOT NULL,
	layout_style tinyint(4) unsigned DEFAULT '0' NOT NULL,
	wrap tinyint(4) unsigned DEFAULT '0' NOT NULL
	container tinyint(4) unsigned DEFAULT '1' NOT NULL
	section_frame tinyint(4) unsigned DEFAULT '0' NOT NULL,
	section_frame_style tinyint(4) unsigned DEFAULT '0' NOT NULL,
	template_media int(11) unsigned DEFAULT '0',
);

#
# Table structure for table 'sys_file_reference'
#
CREATE TABLE sys_file_reference (
	display_mode tinyint(4) DEFAULT '0' NOT NULL
);
