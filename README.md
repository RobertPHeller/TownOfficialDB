# TownOfficialDB
Simple Joomla plugin to insert officals into content.

Syntax -- just include something like this:

{TownOfficial office=someoffice}

on the page somewhere and it will be replaced by a paragraph containing the names and terms of the people elected or appointed to the specified office.

For example this fragment:

<h5>Selectboard</h5>
{TownOfficial office=Selectboard}

Would become:

<h5>Selectboard</h5>
<p>Laurie DiDonato: 2024<br />Gillian Budine 2022<br />Dan Keller 2023</p>



