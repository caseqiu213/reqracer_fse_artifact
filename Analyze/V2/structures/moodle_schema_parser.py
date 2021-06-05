import untangle
# from structures.basics.MyDict import *
from .basics.MyDict import *
class moodle_schema_parser:
	def __init__(self, path):
		self.__table_names = []
		self.__unique_key_names = []
		self.__auto_inc_names = []
		self.__prefix = 'mdl_'
		self.__parse(path)

	def __parse(self, path):
		# obj = untangle.parse("../schema_files/moodle_schema.txt")
		obj = untangle.parse(path)
		tables = obj.XMLDB.TABLES.TABLE
		
		for table in tables:
			# get the table names
			# print(table['NAME'])
			self.__table_names.append(self.__prefix + table['NAME'])
			# get the unique keys
			keys = table.KEYS.KEY
			unique_keys = []
			for key in keys:
				if key['TYPE'] == 'unique' or key['TYPE'] == 'primary':
					# print(key['NAME'])
					unique_keys.append(key['FIELDS'])
			
			# get the auto-increment fields
			fields = table.FIELDS.FIELD
			auto_incs = []
			for field in fields:
				if field['SEQUENCE'] == 'true':
					# print(field['NAME'])
					auto_incs.append(field['NAME'])
			self.__auto_inc_names.append(auto_incs)
			'''TODO: need to consider unique indexes'''
			# get unique indexes
			result = []
			if(hasattr(table,'INDEXES')):
				indexes = table.INDEXES.INDEX
				for index in indexes:
					if index['UNIQUE'] == 'true':
						result = [x.strip() for x in index['FIELDS'].split(",")]
			if(result):
				for i in result:
					unique_keys.append(i)
			self.__unique_key_names.append(unique_keys)
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

# sche_parser = moodle_schema_parser("../../schema_files/moodle_schema.txt")
# print(sche_parser.get_db_dict())