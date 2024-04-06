<?php
/***** important functions which affect all pages *****/ 
/*
//in functions
1-hideItems =>  hide all items if credit is less than max(item_mostafed*3) (in main functions & admin functions)
2-unfavourite items => unfavourite all items if credit is short
3-banned =>if activated==0 => email updated but not verified & if user or trader is banned
4-program => add credit to program partners
5-deleteOrders => delete orders older than 3 months
6-deleteMessage => delete messages older than 1 month
7-changePaidToOne => change all online pay traders to paid=1 in orders table to enable partners get their money
//in processdmin.php in control panel
8-set value for partner's program
9-cut from traders credit    
10-sum and show partner's values in dashboard & dash=program
//in members.php
11-items get hidden if credit is less than max(item_mostafed*3) & online pay=1 (is validated)
//in items
12-show item mostafed in red or black color



*/