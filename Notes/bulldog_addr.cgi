#!/usr/bin/perl -w
# bulldog_addr.cgi  UNFINISHED DRAFT 
# by Greg Severance 7/8/98 2:30 P.M. 
# Montauk, New York Time
# A script to receive name and address of the
# user and store it in a file.
# ----------------------------------------

$webmaster = "tech\@litkicks\.com";
# assigns the variable $webmaster used in subroutine return_error

$document_root = "./Addresses";
$address_file = "/address.txt";
$address_file2 = "/address2.txt";
$address_file3 = "/address3.txt";
$outfile = $document_root . $address_file;
$outfile2 = $document_root . $address_file2;
$outfile3 = $document_root . $address_file3;
## assigning variables for path to the files that
# the script will be appending records to

&parse_form_data (*form_data);
# decodes data coming from the client and puts into
# hash %form_data

$moniker = $form_data{'moniker'};
$address = $form_data{'address'};
$city = $form_data{'city'};
$state = $form_data{'state'};
$country = $form_data{'country'};
$zip = $form_data{'zip'};
$email = $form_data{'email'};
$comment = $form_data{'comment'};
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
# return_blank_field_form -- returns "Oops" form to client

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
    if (!$moniker) {
        &return_blank_field_form;
    }
    elsif (!$address) {
        &return_blank_field_form;
    }
    elsif (!$city) {
        &return_blank_field_form;
    }
    elsif ((!$state) && (!$country)) {
        &return_blank_field_form;
    }
    elsif (!$zip) {
        &return_blank_field_form;
    }
    else {
        &confirm_info_option;
    }   
}

sub confirm_info_option
# This subroutine first appends the user's
# confirmed info to the file address.txt 
# then it returns the acknowledgment html page
# to the user.
{
    $onequote="\"";
    $breakquote="\",\"";

    if ( open (ADDRESS, ">>" . $outfile)) {
        print ADDRESS $onequote,$moniker,$breakquote,$address,$breakquote,
		      $city,$breakquote,$state,$breakquote,$country,$breakquote,
		      $zip,$breakquote,$email,$breakquote,$comment,$onequote,"\n";
        close ADDRESS;
    }
    elsif ( open (ADDRESS, ">>" . $outfile2)) {
        print ADDRESS $onequote,$moniker,$breakquote,$address,$breakquote,
		      $city,$breakquote,$state,$breakquote,$country,$breakquote,
		      $zip,$breakquote,$email,$breakquote,$comment,$onequote,"\n";
        close ADDRESS;
    }
    elsif ( open (ADDRESS, ">>" . $outfile3)) {
        print ADDRESS $onequote,$moniker,$breakquote,$address,$breakquote,
		      $city,$breakquote,$state,$breakquote,$country,$breakquote,
		      $zip,$breakquote,$email,$breakquote,$comment,$onequote,"\n";
        close ADDRESS;
    } else {
        &return_error (500, "Address File Error",
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
$moniker,
<P>
I will try to either send you a copy (if any are left) or respond
to your request via email.  <P> 
-- Levi Asher <P>
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

sub return_blank_field_form
{
    print "Content-type: text/html", "\n\n";
    print <<End_of_Blank_Field;
<HTML>
<HEAD>
<TITLE>Oops</TITLE>
</HEAD>
<BODY BGCOLOR="#000000" TEXT="#FFFFFF" LINK="#00007f">
<!-- background color is "Dostoevsky Black" -->
<H1>Levi Asher's CD-ROM Order Form</H1>
<HR>
<B>Some info was missing.</B>
<P>
<B>Please fill in all the fields in the form below.<BR>
Then click submit.</B><BR>
<FORM ACTION="bulldog_addr.cgi" METHOD="POST">
Please enter your name and address:
<P>
Name:<BR>
<INPUT TYPE="TEXT" SIZE="50" MAXLENGTH="80" NAME="moniker" VALUE="$moniker"><BR>
Address:<BR>
<INPUT TYPE="TEXT" SIZE="50" MAXLENGTH="80" NAME="address" VALUE="$address"><BR>
City:<BR>
<INPUT TYPE="TEXT" SIZE="25" MAXLENGTH="40" NAME="city" VALUE="$city"><BR>
State:<BR>
<INPUT TYPE="TEXT" SIZE="15" MAXLENGTH="15" NAME="state" VALUE="$state"><BR>
Country:<BR>
<INPUT TYPE="TEXT" SIZE="25" MAXLENGTH="40" NAME="country" VALUE="$country"><BR>
Zip Code:<BR>
<INPUT TYPE="TEXT" SIZE="15" MAXLENGTH="15" NAME="zip" VALUE="$zip"><BR>
Email (optional):<BR>
<INPUT TYPE="TEXT" SIZE="50" MAXLENGTH="80" NAME="email" VALUE="$email"><BR><P>
Other Comment? (optional):<BR>
<INPUT TYPE="TEXT" SIZE="50" MAXLENGTH="80" NAME="comment" VALUE="$comment"><BR><P>
<INPUT TYPE="SUBMIT" NAME="option" VALUE="Submit">
<INPUT TYPE="RESET" VALUE="Reset Form">
</FORM>
<A HREF="http://www.litkicks.com/">Literary Kicks</A>
</BODY>
</HTML>

End_of_Blank_Field

exit(1);
}

exit(0);
