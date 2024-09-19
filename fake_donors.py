"""
A script that can generate fake donor data

Some considerations:
1. Usually passwords have specific requirements (min x characters, at least one number and one symbol etc. I did not include that here, it can be added later if we want)
2. Eligibility is dependant on the last donation date, which I have not coded in yet

"""
import os
import numpy as np
import argparse
from typing import NamedTuple
from datetime import datetime
from random import randrange
from datetime import timedelta

def get_name():
    name_length = np.random.randint(3,10)
    # The chr function converts an ASCII value to its equivalent character
    letters = list(map(chr, range(97, 123)))
    np_count = np.asarray(len(letters) * [1])
    np_urn = np.repeat(letters, np_count)
    generate_name = np.random.choice(np_urn, size = name_length, replace = True)
    name = ''.join(generate_name)
    return name


def get_email(f,l):
    mails = ['outlook.com', 'gmail.com', 'yahoo.com', 'icloud.com']
    r = np.random.randint(0, len(mails) - 1)
    mail_provider = mails[r]
    email = f'{f}_{l}@{mail_provider}'
    return email


def get_address():
    regions = []
    with open('counties.csv', 'r') as c:
        line = c.readline()
        while line:
            line = c.readline()
            region = line.split('\t')
            if len(region) > 2:
                regions.append(region[1])
    n = np.random.randint(0, len(regions) - 1)
    return regions[n]

def get_password():
    pass_length = np.random.randint(3,20)
    # The chr function converts an ASCII value to its equivalent character
    characters = list(map(chr, range(33, 126)))
    np_count = np.asarray(len(characters) * [1])
    np_urn = np.repeat(characters, np_count)
    generate_password = np.random.choice(np_urn, size = pass_length, replace = True)
    passwrd = ''.join(generate_password)
    return passwrd

def get_don_date():
    def random_date(start, end):
        """
        This function will return a random datetime between two datetime 
        objects.
        """
        delta = end - start
        int_delta = (delta.days * 24 * 60 * 60) + delta.seconds
        random_second = randrange(int_delta)
        return start + timedelta(seconds=random_second)
    
    d1 = datetime.strptime('1/1/2022', '%m/%d/%Y')
    d2 = datetime.strptime('9/19/2024', '%m/%d/%Y')
    return random_date(d1, d2)

def get_btype():
    types = ['O-', 'O+', 'B-', 'B+', 'A-', 'A+', 'AB-', 'AB+']
    rand_ind = randrange(len(types))
    return types[rand_ind]

def create_sql(N):
    file_name = "insert_donors"
    if os.path.isfile(f"{file_name}.sql"):
        file_name = "insert_donors.sql"
    else:
        val = 1
        new_file_name = f"{file_name}_{val}.sql"
        while os.path.isfile(new_file_name):
            val = val + 1
            new_file_name = f"{file_name}_{val}.sql"
    
        file_name = new_file_name

    for _ in range(N):
        fname = get_name()
        lname = get_name()
        email = get_email(fname,lname)
        address = get_address()
        password = get_password()
        age = np.random.randint(18, 60)
        sex = np.random.choice(np.repeat(['Female', 'Male'], [1,1]) , size = 1, p = None)[0]
        donation_date = get_don_date()
        blood_type = get_btype()
        is_eligible = np.random.choice(np.repeat(['True', 'False'], [1,1]) , size = 1, p = None)[0]

        sql_command = f"INSERT INTO Donor (name, age, sex, address, email, password, blood_type, last_donation_date, is_eligible) VALUES ('{fname} {lname}',{age}, '{sex}', '{address}', '{email}', '{password}', '{blood_type}', '{donation_date}', '{is_eligible}')"

        
        


        with open(file_name, 'a+') as f:
            f.write(f"{sql_command};\n")
    
    f.close()

class Args(NamedTuple):
    """ Command-line arguments """
    n: int

def get_args() -> Args:
    """ Get command-line arguments """

    parser = argparse.ArgumentParser(
        description='Fake Donor Generator',
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