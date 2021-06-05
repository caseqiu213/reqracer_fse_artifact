"""
This class uses FileReaderV2 and QueryParserV2
FileReaderV2 returns a list of dict, e.g. [{PID: }, {RequestID: }, {Query: }...
QueryParserV2 returns multiple
INSERT: [table name], [query dict]
"""
from .basics.FileReaderV2 import *
from .QueryParserV2 import *
from .basics.MyDict import *
# from .QueryParserV2 import *
# from .basics.MyDict import *
# from .basics.FileReaderV2 import *

def _build_instr(content):
	instrs = []
	for line in content:
		instr = Instruction(line, None)
		instrs.append(instr)
	return instrs


class Instruction:
	def __init__(self, line, schema_dict):
		self.__pid = ""
		self.__name = ""
		self.__query = ""
		self.__request_id = ""
		self.__query_id = 0
		self.__query_type = ""
		self.__query_dict = MyDict()
		self.__schema_dict = schema_dict
		self.__content = line

		self.build()

	def build(self):
		self.__pid = self.__content['PID']
		self.__request_id = self.__content['RequestID']
		self.__name = self.__content['Function name']
		if('Query' in self.__content):
			self.__query = self.__content['Query']
		
		
			# parse query string
			query_string = self.__query
			parser = QueryParser(query_string, None)
			parser.parse()
			self.__query_type = parser.get_query_type()
			self.__table_name = parser.get_query_table_name()
			self.__query_dict = parser.get_query_dict()
			query_type = self.__query_type
			# modle queries as RWAD
			if(query_type == "UPDATE"):
				self.__type = "W"
				self.__set_dict = parser.get_set_dict()
			elif(query_type == "SELECT"):
				self.__type = "R"
			elif(query_type == "INSERT"):
				self.__type = "A"
			elif(query_type == "DELETE"):
				self.__type = "D"
		if('InsertID' in self.__content):
			self.__insert_id = self.__content['InsertID']

	def get_set_dict(self):
		return self.__set_dict

	def get_dict(self):
		return self.__query_dict

	def get_name(self):
		return self.__name

	def get_pid(self):
		return self.__pid

	def get_shared_mem(self):
		return self.__shared_mem

	def get_type(self):
		try:
			return self.__type
		except:
			pass

	def set_shared_mem(self, value):
		self.__shared_mem = value

	def get_query(self):
		return self.__query

	def get_request_id(self):
		try:
			return self.__request_id
		except:
			return None

	def get_table_name(self):
		try:
			return self.__table_name
		except:
			return None 

	def set_query_id(self, id):
		self.__query_id = id

	def get_query_id(self):
		return self.__query_id

	def get_query_type(self):
		try:
			return self.__query_type
		except:
			return None

	def get_insert_id(self):
		try:
			return self.__insert_id
		except:
			return None

	def set_request_id(self, myid):
		self.__request_id = myid

# testing
# fp = "../../logs/2088.log"
# fr = FileReader(fp)
# fr.parse()

# content = fr.get_content()
# instrs = _build_instr(content)
