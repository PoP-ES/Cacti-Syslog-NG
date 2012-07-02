Cacti-Pmacct
============

A cacti module to display Syslog-NG logs.

== Install ==
* Install Plugin Architecture if cacti version < 0.8.8
* Copy syslog dir to $CACTI_DIR/plugins
* Edit $CACTI_DIR/include/config.php file. Locate "$plugins = array();" line and add "$plugins[] = 'syslog';" below it.
* Login as admin and go to Settings -> Syslog to configure it.

Now you should see a new Syslog tab.
