LICENSE AND STUFF:

Copyright (c) 2014

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

This license applies to the code only and not to the DogePos name or brand.

---------------------------------------------------------------

DOGEPOS CODE:
DogePos is a simple to use point of sales (POS) app that allows small businesses to accept bitcoin and dogecoin at their retail locations. This software was originally developed in two weeks, on the side, by one person, for use at Strange Donuts. Strange Donuts, and many others, have been using it ever since. Minor improvements have been made, but all in all, the code is pretty rough. It functions, but there's plenty of room for improvement.

DOGEPOS SERVICE:
DogePos servers (dogepos.com) are run and maintained by parent company Rampant Interactive. The DogePos service will remain free for everyone for the lifetime of the service. We look to the community to financially support the continuance of the service. Server costs are expensive, and since we are not charging anything for the service, we need donations to help us keep it running.

Doge Donations: DPgKdeXG1w2R5qxJcxZcuNxHKCRBwkgMZh
Bitcoin Donations: 12ahF79GB15FatWRoXDt2AEU3N84g1rcwy



INSTALLATION

1. Download and install the wallet API following instructions here: https://github.com/triola/DogePos-Wallet-API

2. Open up db-settings.php. Update this file with your database credentials, your wallet handshake key, and your wallet API addresses

2. Import the dogepos_db_template.sql database template into your sql database.

3. The template database contains the following admin user:
user: tempadmin
pw: tothemoon
pin: 1234

4. You should immediately create a new admin level user and delete the temp from the Admin Users interface


Things to note:
This code works, but was built hastily. It doesn't really follow MVC correctly and really needs quite a bit of tidying up.
Everything user login related was built off the User Cake framework (and it shows).
There are a few features that were started but not finished.

I'll try to update soon with a list of desired features/updates.



//--Credits

DogePos created by: Ben Triola / Rampant Interactive (http://therampant.com)
@dogepos
@bentriola
@therampant

---------------------------------------------------------------

Vers: 0.2
http://dogepos.com

