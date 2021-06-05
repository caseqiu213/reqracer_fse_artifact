'''
Finished

return a dictionary of [table_name, unique_kyes[...]]
'''
from .basics.MyDict import *
import sqlparse
import re

class SchemaParser:
    def __init__(self, path):
        self.__path = path
        queries = ""
        with open(self.__path, 'r') as f:
            for line in f:
                queries += line

        self.__data = sqlparse.format(queries, keyword_case="upper", identifier_case="lower", strip_comments=True).strip()
        self.__table_names = []
        self.__unique_key_names = []
        self.__uniques = []
        self.__autos = []
        self.__auto_inc_names = []
        self.__prime = []

        self.__break_loop = 0

        self.__parse()

    def __remove_symbols(self, name):
        name = name.replace(" ", "")
        name = name.replace(")", "")
        name = name.replace("(", "")
        return name

    def __get_comma_partition(self, name):
        index = 0
        for pkey in name.partition(","):
            if (index % 2 == 0):
                if(pkey):
                    pkey = self.__remove_symbols(pkey)
                    self.__uniques.append(pkey)
            index += 1

    def __get_comma_partition_prime(self, name):
        index = 0
        for pkey in name.partition(","):
            if (index % 2 == 0):
                if(pkey):
                    pkey = self.__remove_symbols(pkey)
                    self.__uniques.insert(0, pkey)
            index += 1

    def __replace_wpdb(self, name):
        return name.replace("$wpdb->", "wp_")

    def __parse(self):
        count = 0
        for query in (sqlparse.split(self.__data)):
            # if (query.find("CREATE TABLE") != -1):
            my_list = (query.split("\n"))
            for line in my_list:
                # print ("====================")
                # print (line)
                if("CREATE TABLE" in line):
                    line = line.strip()
                    name = line.partition("CREATE TABLE")[2]
                    table_name = self.__remove_symbols(name)
                    table_name = self.__replace_wpdb(table_name)
                    self.__table_names.append(table_name)
                    self.__auto_inc_names.append([[]])
                    self.__unique_key_names.append(self.__uniques)
                    if(self.__uniques):
                        self.__uniques = []
                if("PRIMARY KEY" in line):
                    line = line.strip()
                    if(line.startswith("PRIMARY KEY")):
                        name = line.partition("PRIMARY KEY")[2]
                        self.__get_comma_partition_prime(name)
                        # self.__get_comma_partition(name)
                    else:
                        pkey = line.partition(" ")[0]
                        # self.__prime.append(pkey)
                        self.__uniques.insert(0, pkey)
                if("UNIQUE KEY" in line):
                    line = line.strip()
                    # name = re.search(r'(\(.*\))', line)
                    pkey = line.partition("UNIQUE KEY ")[2]
                    name = pkey.partition(" ")[0]
                    self.__get_comma_partition(name)
                if("UNIQUE INDEX" in line):
                    line = line.strip()
                    # name = re.search(r'(\(.*\))', line)
                    pkey = line.partition("UNIQUE INDEX ")[2]
                    name = pkey.partition(" ")[0]
                    self.__get_comma_partition(name)
                if("auto_increment" in line or "AUTO_INCREMENT" in line):
                    line = line.strip()
                    self.__autos.append(line.partition(" ")[0].lower())
                    self.__auto_inc_names.pop()
                    self.__auto_inc_names.append([line.partition(" ")[0].lower()])

                # if(re.search("\).*[$].*;", line)):
                #     print(self.__autos)
                #     count+=1
                #     self.__auto_inc_names.append(self.__autos)
                #     self.__autos = []
                if("FUNCTION" in line):
                    # break
                    self.__break_loop = 1
                    break
            if(self.__break_loop):
                break
        self.__unique_key_names.append(self.__uniques)
        self.__unique_key_names.pop(0)
        # for i in self.__unique_key_names:
        #     print (i)
        # print(len(self.__table_names))
        # print(len(self.__auto_inc_names))
        # print(len(self.__unique_key_names))
        self.__build_dict()
        self.__build_autoinc_dict()

    def __build_autoinc_dict(self):
        self.__auto_inc = MyDict()
        i = 0
        while (i < len(self.__table_names)):
            self.__auto_inc.add(self.__table_names[i], self.__auto_inc_names[i])
            i += 1


    def __build_dict(self):
        self.__dict_obj = MyDict()
        i = 0
        while (i < len(self.__table_names)):
            self.__dict_obj.add(self.__table_names[i], self.__unique_key_names[i]) 
            i += 1

    def get_table_names(self):
        return self.__table_names

    def get_unique_key_names(self):
        return self.__unique_key_names

    def get_db_dict(self):
        return self.__dict_obj

    def get_autoinc_dict(self):
        return self.__auto_inc
