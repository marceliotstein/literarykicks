#!/usr/bin/perl -w
# bulldog_survey.cgi  
# ----------------------------------------

$webmaster = "tech\@litkicks\.com";
# assigns the variable $webmaster used in subroutine return_error

$document_root = "./Feedback";
$feedback_file = "/feedback.txt";
$feedback_file2 = "/feedback2.txt";
$feedback_file3 = "/feedback3.txt";
$outfile = $document_root . $feedback_file;
$outfile2 = $document_root . $feedback_file2;
$outfile3 = $document_root . $feedback_file3;
## assigning variables for path to the files that
# the script will be appending records to

&parse_form_data (*form_data);
# decodes data coming from the client and puts into
# hash %form_data

$whatsystem = $form_data{'whatsystem'};
$diditwork = $form_data{'diditwork'};
$didyoulike = $form_data{'didyoulike'};
$whataboutphil = $form_data{'whataboutphil'};
$wouldyoupay = $form_data{'wouldyoupay'};
$othercomment = $form_data{'othercomment'};
$moniker = $form_data{'moniker'};
$email = $form_data{'email'};
$option = $form_data{'option'};
# assigns variables

if ($option eq "Submit") {     
    &submit_option;
}
else {
    &return_error (500, "Server Error",
                        "Server uses unsupported method");
}

# Here is an index of the subroutines used by this script:
# parse_form_data         -- decodes data submitted by client
# submit_option           -- called if option value is "Submit"
# return_error            -- returns error msg to client

sub parse_form_data    # from _CGI Programming on the World
{                      # Wide Web_ by Shishir Gundavaram
    local (*FORM_DATA) = @_;

    local ( $request_method, $query_string, @key_value_pairs,
           $key_value, $key, $value);

    $request_method = $ENV{'REQUEST_METHOD'};

    if ($request_method eq "GET") {
        $query_string = $ENV{'QUERY_STRING'};
    } elsif ($request_method eq "POST") {
        read (STDIN, $query_string, $ENV{'CONTENT_LENGTH'});
    } else {
        &return_error (500, "Server Error",
                       "Server uses unsupported method");
    }

    @key_value_pairs = split (/&/, $query_string);

    foreach $key_value (@key_value_pairs) {
        ($key, $value) = split (/=/, $key_value);
        $value =~ tr/+/ /;
        $value =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;

        if (defined($FORM_DATA{$key})) {
            $FORM_DATA{$key} = join ("\0", $FORM_DATA{$key}, $value);
        } else {
            $FORM_DATA{$key} = $value;
        }
    }
}

sub submit_option
{
    &confirm_info_option;
}

sub confirm_info_option
# This subroutine first appends the user's
# confirmed info to the file feedback.txt 
# then it returns the acknowledgment html page
# to the user.
{
    $onequote="\"";
    $breakquote="\",\"";

    if ( open (FEEDBACK, ">>" . $outfile)) {
        print FEEDBACK $onequote,$whatsystem,$breakquote,$diditwork,$breakquote,
		      $didyoulike,$breakquote,$whataboutphil,$breakquote,$wouldyoupay,$breakquote,
		      $othercomment,$breakquote,$moniker,$breakquote,$email,$onequote,"\n";
        close FEEDBACK;
    }
    elsif ( open (FEEDBACK, ">>" . $outfile2)) {
        print FEEDBACK $onequote,$whatsystem,$breakquote,$diditwork,$breakquote,
		      $didyoulike,$breakquote,$whataboutphil,$breakquote,$wouldyoupay,$breakquote,
		      $othercomment,$breakquote,$moniker,$breakquote,$email,$onequote,"\n";
        close FEEDBACK;
    }
    elsif ( open (FEEDBACK, ">>" . $outfile3)) {
        print FEEDBACK $onequote,$whatsystem,$breakquote,$diditwork,$breakquote,
		      $didyoulike,$breakquote,$whataboutphil,$breakquote,$wouldyoupay,$breakquote,
		      $othercomment,$breakquote,$moniker,$breakquote,$email,$onequote,"\n";
        close FEEDBACK;
    } else {
        &return_error (500, "Feedback File Error",
            "Cannot write to output file [$outfile] -- please try again later!.");
    }

    print "Content-type: text/html", "\n\n";
    print <<End_of_Thanks;

<HTML>
<HEAD>
<TITLE>Thanks</TITLE>
</HEAD>
<BODY BGCOLOR="#000000" TEXT="#FFFFFF" LINK="#00007f">
<!-- background color is "Dostoevsky Black" -->
<H1>Thanks</H1>
<P>
Your responses have been recorded -- thanks for your help.
<P>
-- Levi Asher
<P>
<A HREF="http://www.litkicks.com/">Literary Kicks</A>
</BODY>
</HTML>

End_of_Thanks

exit(1);
}

sub return_error    # from _CGI Programming on the World
{                   # Wide Web_ by Shishir Gundavaram
    local ($status, $keyword, $message) = @_;

    print "Content-type: text/html", "\n";
    print "Status: ", $status, " ", $keyword, "\n\n";

    print <<End_of_Error;

<title>CGI Program - Unexpected Error</title>
<h1>$keyword</h1>
<hr>$message</hr>
Please contact $webmaster for more information.

End_of_Error

exit(1);
}

exit(0);
