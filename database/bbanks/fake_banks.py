"""
A script that can generate fake donor data

insert_donors_1.sql is an example of the commands that have been made

Some considerations:
1. Usually passwords have specific requirements (min x characters, at least one number and one symbol etc. I did not include that here, it can be added later if we want)
2. Eligibility is dependant on the last donation date, which I have not coded in yet


"""
import os
import numpy as np
import argparse
from typing import NamedTuple
from datetime import datetime, timedelta
from random import randrange
from datetime import timedelta
import hashlib
# import bcrypt

servername = "localhost"
username = "root"
password = "root"
dbname = "twister"

class BloodBank:
    def __init__(self, name):
        self.name = name
        self.email = ''
        self.region = ''
        self.password = ''
        self.hashed_password = ''



def get_bb_name(i):
    
    basename = "Blood Bank No. "
    bbname = basename + str(i)
    new_bank = BloodBank(bbname)
    get_email(new_bank)
    get_address(new_bank)
    get_password(new_bank)
    
    return new_bank



def get_email(bb: BloodBank):
    mails = ['outlook.com', 'gmail.com', 'yahoo.com', 'icloud.com']
    r = np.random.randint(0, len(mails) - 1)
    suffix = randrange(5000)
    mail_provider = mails[r]
    email = f'bloodbank_{suffix}@{mail_provider}'
    bb.email = email



def get_address(bb:BloodBank):
    regions = []
    try:
        with open('../counties.csv', 'r') as c:
            line = c.readline()
            while line:
                line = c.readline()
                region = line.split('\t')
                if len(region) > 2:
                    regions.append(region[1])
    except FileNotFoundError:
        print("The file you are trying to open does not exist")
    n = np.random.randint(1, len(regions))
    bb.region = n
    return 1

def get_password(bb:BloodBank):
    pass_length = np.random.randint(6,20)
    # The chr function converts an ASCII value to its equivalent character
    characters = list(map(chr, range(33, 126)))
    np_count = np.asarray(len(characters) * [1])
    np_urn = np.repeat(characters, np_count)
    generate_password = np.random.choice(np_urn, size = pass_length, replace = True)
    passwrd = f"{''.join(generate_password)}{bb.email}"
    hashed_passwrd = hashlib.md5(passwrd.encode())
    hashed_passwrd = hashed_passwrd.hexdigest()
    bb.password = passwrd
    bb.hashed_password = hashed_passwrd
    return passwrd, hashed_passwrd

def create_sql(N):
    blood_banks: list[BloodBank] = []
    sql_file_name = "insert_blood_banks.sql"


    for i in range(N):

        bbname = get_bb_name(i)
        blood_banks.append(bbname)
    
    for bb in blood_banks:
        
        

        with open('blood_banks.csv', 'a+') as blood_banks:
            blood_banks.write(f'{bb.email}\t{bb.password}\n')


        sql_command = f"INSERT INTO Blood_Bank (name, region_id, email, password) VALUES ('{bb.name}', {bb.region},'{bb.email}', '{bb.hashed_password}')"

        


        with open(sql_file_name, 'a+') as f:
            f.write(f"{sql_command};\n")
    
    f.close()

class Args(NamedTuple):
    """ Command-line arguments """
    n: int

def get_args() -> Args:
    """ Get command-line arguments """

    parser = argparse.ArgumentParser(
        description='Fake Blood Bank Generator',
        formatter_class=argparse.ArgumentDefaultsHelpFormatter)

    # because there is no default, then it must have a value
    parser.add_argument('n', metavar='n', help='The number of fake donors to create',
                        type=int)
    args = parser.parse_args()
    return Args(args.n)

def main() -> None:

    args = get_args()
    n = args.n

    create_sql(n)


if __name__ == '__main__':

    main()