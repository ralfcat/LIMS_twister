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

def get_full_name_gender():
    name_gender_dict = {
    "James": "Male", "Mary": "Female",
    "Michael": "Male", "Patricia": "Female",
    "Robert": "Male", "Jennifer": "Female",
    "John": "Male", "Linda": "Female",
    "David": "Male", "Elizabeth": "Female",
    "William": "Male", "Barbara": "Female",
    "Richard": "Male", "Susan": "Female",
    "Joseph": "Male", "Jessica": "Female",
    "Thomas": "Male", "Karen": "Female",
    "Christopher": "Male", "Sarah": "Female",
    "Charles": "Male", "Lisa": "Female",
    "Daniel": "Male", "Nancy": "Female",
    "Matthew": "Male", "Sandra": "Female",
    "Anthony": "Male", "Betty": "Female",
    "Mark": "Male", "Ashley": "Female",
    "Donald": "Male", "Emily": "Female",
    "Steven": "Male", "Kimberly": "Female",
    "Andrew": "Male", "Margaret": "Female",
    "Paul": "Male", "Donna": "Female",
    "Joshua": "Male", "Michelle": "Female",
    "Kenneth": "Male", "Carol": "Female",
    "Kevin": "Male", "Amanda": "Female",
    "Brian": "Male", "Melissa": "Female",
    "Timothy": "Male", "Deborah": "Female",
    "Ronald": "Male", "Stephanie": "Female",
    "George": "Male", "Rebecca": "Female",
    "Jason": "Male", "Sharon": "Female",
    "Edward": "Male", "Laura": "Female",
    "Jeffrey": "Male", "Cynthia": "Female",
    "Ryan": "Male", "Dorothy": "Female",
    "Jacob": "Male", "Amy": "Female",
    "Nicholas": "Male", "Kathleen": "Female",
    "Gary": "Male", "Angela": "Female",
    "Eric": "Male", "Shirley": "Female",
    "Jonathan": "Male", "Emma": "Female",
    "Stephen": "Male", "Brenda": "Female",
    "Larry": "Male", "Pamela": "Female",
    "Justin": "Male", "Nicole": "Female",
    "Scott": "Male", "Anna": "Female",
    "Brandon": "Male", "Samantha": "Female",
    "Benjamin": "Male", "Katherine": "Female",
    "Samuel": "Male", "Christine": "Female",
    "Gregory": "Male", "Debra": "Female",
    "Alexander": "Male", "Rachel": "Female",
    "Patrick": "Male", "Carolyn": "Female",
    "Frank": "Male", "Janet": "Female",
    "Raymond": "Male", "Maria": "Female",
    "Jack": "Male", "Olivia": "Female",
    "Dennis": "Male", "Heather": "Female",
    "Jerry": "Male", "Helen": "Female",
    "Tyler": "Male", "Catherine": "Female",
    "Aaron": "Male", "Diane": "Female",
    "Jose": "Male", "Julie": "Female",
    "Adam": "Male", "Victoria": "Female",
    "Nathan": "Male", "Joyce": "Female",
    "Henry": "Male", "Lauren": "Female",
    "Zachary": "Male", "Kelly": "Female",
    "Douglas": "Male", "Christina": "Female",
    "Peter": "Male", "Ruth": "Female",
    "Kyle": "Male", "Joan": "Female",
    "Noah": "Male", "Virginia": "Female",
    "Ethan": "Male", "Judith": "Female",
    "Jeremy": "Male", "Evelyn": "Female",
    "Christian": "Male", "Hannah": "Female",
    "Walter": "Male", "Andrea": "Female",
    "Keith": "Male", "Megan": "Female",
    "Austin": "Male", "Cheryl": "Female",
    "Roger": "Male", "Jacqueline": "Female",
    "Terry": "Male", "Madison": "Female",
    "Sean": "Male", "Teresa": "Female",
    "Gerald": "Male", "Abigail": "Female",
    "Carl": "Male", "Sophia": "Female",
    "Dylan": "Male", "Martha": "Female",
    "Harold": "Male", "Sara": "Female",
    "Jordan": "Male", "Gloria": "Female",
    "Jesse": "Male", "Janice": "Female",
    "Bryan": "Male", "Kathryn": "Female",
    "Lawrence": "Male", "Ann": "Female",
    "Arthur": "Male", "Isabella": "Female",
    "Gabriel": "Male", "Judy": "Female",
    "Bruce": "Male", "Charlotte": "Female",
    "Logan": "Male", "Julia": "Female",
    "Billy": "Male", "Grace": "Female",
    "Joe": "Male", "Amber": "Female",
    "Alan": "Male", "Alice": "Female",
    "Juan": "Male", "Jean": "Female",
    "Elijah": "Male", "Denise": "Female",
    "Willie": "Male", "Frances": "Female",
    "Albert": "Male", "Danielle": "Female",
    "Wayne": "Male", "Marilyn": "Female",
    "Randy": "Male", "Natalie": "Female",
    "Mason": "Male", "Beverly": "Female",
    "Vincent": "Male", "Diana": "Female",
    "Liam": "Male", "Brittany": "Female",
    "Roy": "Male", "Theresa": "Female",
    "Bobby": "Male", "Kayla": "Female",
    "Caleb": "Male", "Alexis": "Female",
    "Bradley": "Male", "Doris": "Female",
    "Russell": "Male", "Lori": "Female",
    "Lucas": "Male", "Tiffany": "Female"
}
    last_names = [
    "Smith", "Johnson", "Williams", "Brown", "Jones", 
    "Garcia", "Miller", "Davis", "Rodriguez", "Martinez", 
    "Wilson", "Anderson", "Thomas", "Taylor", "Moore", 
    "Jackson", "Martin", "Lee", "Perez", "Thompson", 
    "White", "Harris", "Sanchez", "Clark", "Lewis"
]

    ran = randrange(len(name_gender_dict))
    fname = list(name_gender_dict)[ran]
    gender = list(name_gender_dict.values())[ran]
    ran = randrange(len(last_names))
    lname = last_names[ran]
    return (fname,lname, gender)


def get_email(f,l):
    mails = ['outlook.com', 'gmail.com', 'yahoo.com', 'icloud.com']
    r = np.random.randint(0, len(mails) - 1)
    suffix = randrange(3000)
    mail_provider = mails[r]
    email = f'{f}_{l}_{suffix}@{mail_provider}'
    return email


def get_address():
    regions = []
    FILE_NAME = '../counties.csv'
    try:
        with open(FILE_NAME, 'r') as c:
            line = c.readline()
            while line:
                line = c.readline()
                region = line.split('\t')
                if len(region) > 2:
                    regions.append(region[1])
        n = np.random.randint(0, len(regions) - 1)
        return regions[n]
    except FileNotFoundError:
        print(f"The file you are trying to open ({FILE_NAME}) does not exist")
        exit()

def get_password():
    pass_length = np.random.randint(6,20)
    # The chr function converts an ASCII value to its equivalent character
    characters = list(map(chr, range(33, 126)))
    np_count = np.asarray(len(characters) * [1])
    np_urn = np.repeat(characters, np_count)
    generate_password = np.random.choice(np_urn, size = pass_length, replace = True)
    passwrd = ''.join(generate_password)
    hashed_passwrd = hashlib.md5(passwrd.encode())
    hashed_passwrd = hashed_passwrd.hexdigest()
    return passwrd, hashed_passwrd

def is_eligible(don_date):
    """
    This function will determine if the donor has donated within the last 6 months, determining eligibility

    """
    # datetime.datetime(2023, 12, 11, 14, 32, 26)
    # x = get_don_date()
    # >>> x
    # datetime.datetime(2024, 3, 26, 17, 36, 57)
    # >>> x - timedelta(days = 6 * 30)
    # datetime.datetime(2023, 9, 28, 17, 36, 57)
    ...
    #  get the current time
    curr_time = datetime.now()
    # get the time 6 months ago 
    six_mon_ago = curr_time - timedelta(days = 6 * 30)
    if six_mon_ago <= don_date <= curr_time:
        return True
    return False

    




    

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

        fname, lname, sex = get_full_name_gender()
        email = get_email(fname,lname).lower()
        address = get_address()
        password, hashed_pass = get_password()

        with open('users.csv', 'a') as users:
            users.write(f'{email}\t{password}\n')
        age = np.random.randint(18, 60)
        # sex = np.random.choice(np.repeat(['Female', 'Male'], [1,1]) , size = 1, p = None)[0]
        donation_date = get_don_date()
        blood_type = get_btype()
        # is_eligible = np.random.choice(np.repeat(['True', 'False'], [1,1]) , size = 1, p = None)[0]
        is_eli = is_eligible(donation_date)

        sql_command = f"INSERT INTO Donor (name, age, sex, address, email, password, blood_type, last_donation_date, is_eligible) VALUES ('{fname} {lname}',{age}, '{sex}', '{address}', '{email}', '{hashed_pass}', '{blood_type}', '{donation_date}', {is_eli})"

        


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