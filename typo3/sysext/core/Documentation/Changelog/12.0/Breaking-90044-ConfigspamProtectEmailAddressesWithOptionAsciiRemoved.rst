.. include:: ../../Includes.txt

===============================================================================
Breaking: #90044 - config.spamProtectEmailAddresses with option "ascii" removed
===============================================================================

See :issue:`90044`

Description
===========

The TypoScript setting `config.spamProtectEmailAddresses` set to `ascii` has no
effect anymore as the ASCII-encryption feature has been removed.

The option changed any links to emails like `href="mailto:benni@example.com"`
to point to the ASCII-encoded equivalent. Since all browsers (and most bots/crawlers)
do this automatically and instantly this feature has no spam-protection
relevance anymore.


Impact
======

Setting the option to `ascii` has no effect anymore, which is the same as not
setting the option at all. However, in case the option is set to `ascii` a
deprecation error is thrown.


Affected Installations
======================

TYPO3 installations having this option set in their TypoScript setup.


Migration
=========

In case you still want to keep a email SPAM protection around, it is recommended
to set the option `config.spamProtectEmailAddresses` to a numeric value between
-10 and 10.

Alternatively, there is an extension called `emailobfuscator` available in the
TYPO3 Extension Repository, which also aims to achieve a similar behaviour.

.. index:: Frontend, TypoScript, NotScanned, ext:frontend
