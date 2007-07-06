{**
 * proofGalley.tpl
 *
 * Copyright (c) 2000-2007 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Proof a galley.
 *
 * $Id$
 *}

{assign var="pageTitle" value="submission.layout.viewingGalley"}

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset={$defaultCharset}" />
	<title>{translate key=$pageTitle}</title>

	<link rel="stylesheet" href="{$baseUrl}/styles/common.css" type="text/css" />

	{foreach from=$stylesheets item=cssUrl}
		<link rel="stylesheet" href="{$cssUrl}" type="text/css" />
	{/foreach}

	<link rel="alternate stylesheet" title="{translate key="icon.small.alt"}" href="{$baseUrl}/styles/small.css" type="text/css" />
	<link rel="stylesheet" title="{translate key="icon.medium.alt"}" href="{$baseUrl}/styles/medium.css" type="text/css" />
	<link rel="alternate stylesheet" title="{translate key="icon.large.alt"}" href="{$baseUrl}/styles/large.css" type="text/css" />
</head>
{url|assign:"galleyUrl" op="proofGalleyFile" path=$paperId|to_array:$galleyId}
<frameset rows="40,*" frameborder="0" framespacing="0" style="border: 0;">
	<frame src="{url op="proofGalleyTop" path=$paperId}" noresize="noresize" frameborder="0" scrolling="no" />
	<frame src="{$galleyUrl}" frameborder="0" />
<noframes>
<body>
	<table width="100%">
		<tr>
			<td align="center">
				{translate key="common.error.framesRequired" url=$galleyUrl}
			</td>
		</tr>
	</table>
</body>
</noframes>
</frameset>
</html>
