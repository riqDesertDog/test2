#!/usr/local/bin/perl
# ==================================================================
# File manager - enhanced web based file management system
#
#   Website  : http://gossamer-threads.com/
#   Support  : http://gossamer-threads.com/scripts/support/
#   Revision : $Id: fileman.cgi,v 1.10 2003/02/07 19:57:13 alex Exp $
# 
# Copyright (c) 2001 Gossamer Threads Inc.  All Rights Reserved.
# Redistribution in part or in whole strictly prohibited. Please
# see LICENSE file for full details.
# ==================================================================
    use lib '/data/config/fileman/lib';
    use strict;
    use vars qw/$CFG_PATH/;
    
    use GT::Base qw/:all/;
    use GT::CGI;
    use GT::FileMan;
    
    $| = 1;
    local $SIG{__DIE__}   = \&GT::FileMan::fatal;
   
    $CFG_PATH = '/data/config/fileman/lib/FileMan/ConfigData.pm';
    
    main();

sub main () {
#-------------------------------------------------------------------
#   Main process
#
            require FileMan::Admin;
        my $fm = new FileMan::Admin;
        $fm->process(cfg_path => $CFG_PATH);

}

