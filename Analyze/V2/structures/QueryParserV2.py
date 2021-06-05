# from basics.MyDict import *
# from basics.FileReaderV2 import *
from .basics.MyDict import *
from .basics.FileReaderV2 import *
import sqlparse

'''
The parser is adpated from github.com/simkoc/raccoon
'''

def remove_symbols(name):
	name = name.replace("`", "")
	# name = name.replace("'", "")
	if("." == name[:-1] or "." == name[:-2]):
		name = name.replace(".", "")
	return name

def merge_table_and_columns(tables, columns, logger=None):
	columns = list(set(columns))
	certain = len(tables) == 1
	ret = []
	for table in tables:
		if table[0] == '`':
			table = table[1:]
		if table[-1] == '`':
			table = table[0:-1]
		print(table)
		# for column in columns:
		# 	print(column)


def position_of_keyword(stmtl, of, pos=0):
	if len(stmtl) == pos:
		# print("return none")
		return None
	else:
		if stmtl[pos].is_keyword and stmtl[pos].value.upper() == of:
			return pos
		elif type(stmtl[pos]) == sqlparse.sql.Where:
			if stmtl[pos].tokens[0].value.upper() == of:
				return pos
		else:
			return position_of_keyword(stmtl, of, pos+1)

def analyze_identifier_list(identlist, keywords_are_identifiers=False, logger=None):
	if identlist is None:
		identlist = []
	ret = []
	for token in identlist:
		if type(token) == sqlparse.sql.Function:
			ret += analyze_function(token, logger)
		elif type(token) == sqlparse.sql.Identifier:
			if token.get_real_name() == 'special':
				pass
			else:
				# could be table name or column name
				ret.append(token.get_real_name())
		elif type(token) == sqlparse.sql.Token and token.value == "*":
			ret += ["*"]
		elif type(token) == sqlparse.sql.Parenthesis:
			ret += analyze_parenthesis(token, logger)
		elif type(token) == sqlparse.sql.Operation:
			ret += analyze_identifier_list(token.tokens, keywords_are_identifiers=True)
		elif type(token) == sqlparse.sql.IdentifierList:
			ret += analyze_identifier_list(token.get_identifiers())
		elif token.ttype == sqlparse.tokens.Token.String.Single:
			pass
		elif token.ttype == sqlparse.tokens.Token.Operator:
			pass
		elif type(token) == sqlparse.sql.Comparison:
			ret += analyze_identifier_list([token.left], keywords_are_identifiers=True, logger=logger)
			ret += analyze_identifier_list([token.right], keywords_are_identifiers=True, logger=logger)
		elif token.is_keyword:
			# ZY: do not put keywords in ret
			pass
			# if keywords_are_identifiers:
			# 	ret += token.value
		elif token.is_whitespace:
			pass
		elif str(token.ttype) == "Token.Literal.Number.Integer":
			# print("FIXED VALUE")
			pass
		else:
			# print("SqlParser does not handle this")
			pass
	return ret

def analyze_function(function, logger=None):
	assert type(function) == sqlparse.sql.Function, "analyze_function expects a function"
	return analyze_identifier_list(function.get_parameters(),
									keywords_are_identifiers=True,
									logger=logger)

def analyze_parenthesis(token, logger=None):
	assert str(token.tokens[0].ttype) == 'Token.Punctuation', "first element has to be punctuation"
	assert str(token.tokens[-1].ttype) == 'Token.Punctuation', "last element has to be punctuation"
	return analyze_identifier_list(token.tokens[1:-1], logger=logger)

def analyze_set_sublist(token_list, logger=None):
	ret = MyDict()
	for token in token_list:
		if token.value == "=":
			index = token_list.index(token)
			column = remove_symbols(token_list[index-1].value)
			value = remove_symbols(token_list[index+1].value)
			ret.add(column, value)
	return ret

def analyze_where_sublist(identlist, logger=None):
	# ZY: buid a query dict{column: value}
	if identlist is None:
		identlist = []
	identlist = [token for token in identlist if not token.is_whitespace]
	ret = MyDict()
	for token in identlist:
		if token.value == "=":
			# column = analyze_identifier_list([token.left], keywords_are_identifiers=True, logger=logger)
			# if not column:
				# column = remove_symbols(token.left.value)
			column = remove_symbols(identlist[identlist.index(token)-1].value)
			value = remove_symbols(identlist[identlist.index(token)+1].value)
			# print(column)
			# print(value)
			# ret.add(column[0], value)
			ret.add(column, value)
		if(token.is_keyword and token.value.upper() == "IN"):
			pos_in = position_of_keyword(identlist, "IN")
			column = identlist[pos_in-1].value
			temp_value = []
			value_token = identlist[pos_in+1]
			token_list = list(value_token.flatten())
			for i in range(len(token_list)):
				if(token_list[i].value == ")"):
					break
				if(str(token_list[i].ttype) == "Token.Punctuation" and token_list[i].value != ")"):
					continue
				else:
					temp_value.append(token_list[i].value)
			for value in temp_value:
				ret.add(column, value)
	return ret

def get_from_sublist(token_list, logger=None):
	pos_from = position_of_keyword(token_list, 'FROM')
	pos_where = position_of_keyword(token_list, 'WHERE')
	pos_group = position_of_keyword(token_list, 'GROUP')
	pos_having = position_of_keyword(token_list, 'HAVING')
	pos_order = position_of_keyword(token_list, 'ORDER')
	pos_limit = position_of_keyword(token_list, 'LIMIT')
	pos_join = position_of_keyword(token_list, 'JOIN')
	ll = [pos_where, pos_group, pos_having, pos_order, pos_limit, pos_join]
	ll = [elem for elem in ll if elem is not None]
	if len(ll) != 0:
		# return token_list[pos_from+1:ll[0]], True if pos_group is not None else False
		# ZY:
		return token_list[pos_from+1:pos_from+2], True if pos_group is not None else False
	elif(pos_from):
		return token_list[pos_from+1:pos_from+2], True if pos_group is not None else False

def analyze_select_statement(token_list, logger=None):
	token_list = [token for token in token_list if not token.is_whitespace]
	uses = []
	defines = []
	tables = []

	# ZY: check subquery, we do not handle
	flag = 0
	has_from = 0
	dml_counter = 0
	for token in token_list:
		if "MASTER_POS_WAIT" in token.value.upper():
			return [], {}
		if token.value.upper() == "FOUND_ROWS()":
			return [],{}
		# if token.value.upper() == "SQL_CALC_FOUND_ROWS":
		# 	return [],{}
		if token.value == "UNION ALL":
			flag = 1
		if token.ttype == sqlparse.tokens.Token.Keyword.DML:
			dml_counter += 1
		if token.is_keyword and token.value.upper() == "FROM":
			has_from = 1
	# if the query does not have UNION ALL and has more than 1 SELECT
	if not flag and dml_counter > 1:
		# print("we do not handle subquery in select")
		return [],{}

	if has_from:
		from_sublist, aggregate_p = get_from_sublist(token_list, logger)
		if from_sublist is not None:
			tables = analyze_identifier_list(from_sublist,
									keywords_are_identifiers=True,
									logger=logger)
	if token_list[1].is_keyword and token_list[1].value.upper()in ['DINSTINCT']:
		uses = analyze_identifier_list(token_list[2:3],
										keywords_are_identifiers=True,
										logger=logger)
	else:
		uses = analyze_identifier_list(token_list[1:2],
										keywords_are_identifiers=True,
										logger=logger)

	# print(uses)
	# the columns selected
	query_dict = []
	where = [item for item in token_list if type(item) == sqlparse.sql.Where]
	if len(where):
		query_dict.append(analyze_where_sublist(list(where[0].flatten())))

	# ZY: handle union all
	for token in token_list:
		if token.value == "UNION ALL":
			union_index = token_list.index(token)
			temp_table, temp_query_dict = analyze_select_statement(token_list[union_index+1:], logger=None)
			tables.append(temp_table[0])
			query_dict.append(temp_query_dict[0])

	temp = []
	for table in tables:
		temp.append(remove_symbols(table))
	tables = temp
	# print(tables)
	# print(query_dict)
	return tables, query_dict

def analyze_update_statement(token_list, query, logger=None):
	token_list = [token for token in token_list if not token.is_whitespace]
	uses = []
	defines = []
	tables = []

	# ZY: check subquery, we do not handle
	flag = 0
	dml_counter = 0
	for token in token_list:
		if token.value.upper() == "UNION ALL":
			flag = 1
		if token.ttype == sqlparse.tokens.Token.Keyword.DML:
			dml_counter += 1
	# if the query does not have UNION ALL and has more than 1 SELECT
	if not flag and dml_counter > 1:
		# print("we do not handle subquery in update")
		return [], {}, {}

	pos_update = position_of_keyword(token_list, "UPDATE")
	pos_set = position_of_keyword(token_list, "SET")
	tables = analyze_identifier_list(token_list[pos_update+1:pos_set],
									keywords_are_identifiers=True,
									logger=None)

	pos_where = position_of_keyword(token_list, "WHERE")
	if pos_where:
		uses = analyze_identifier_list(token_list[pos_where].tokens)
		defines = analyze_identifier_list(token_list[pos_set:pos_where])
	else:
		defines = analyze_identifier_list(token_list[pos_set:-1])
	# print(uses)
	# print(defines)

	# ZY: analyze set token
	parsed = sqlparse.parse(query)
	stmt = parsed[0].flatten()
	temp_token_list = list(stmt)
	temp_token_list = [token for token in temp_token_list if not token.is_whitespace]
	_pos_set = 0
	_pos_where = 0
	for token in temp_token_list:
		if token.value == "SET":
			_pos_set = temp_token_list.index(token)
		if token.value == "WHERE":
			_pos_where = temp_token_list.index(token)
	if _pos_set != 0:
		if _pos_where != 0:
			set_dict = analyze_set_sublist(temp_token_list[_pos_set+1:_pos_where], logger)
		if _pos_where == 0:
			set_dict = analyze_set_sublist(temp_token_list[_pos_set+1:-1], logger)

	where = [item for item in token_list if type(item) == sqlparse.sql.Where]
	query_dict = []
	if len(where):
		query_dict.append(analyze_where_sublist(list(where[0].flatten())))
	temp = []
	for table in tables:
		temp.append(remove_symbols(table))
	tables = temp
	# print(tables)
	# print(query_dict)
	# print(set_dict)
	return tables, query_dict, set_dict

def extract_insert_table_identifier(token_list, logger=None):
	assert len(token_list) == 1, 'the list must be 1'
	if type(token_list[0]) == sqlparse.sql.Function:
		return [token_list[0].get_name()]
	elif type(token_list[0]) == sqlparse.sql.Identifier:
		return [token_list[0].get_real_name()]
	else:
		# print("extract_insert_table_identifier does not handle")
		pass

def analyze_insert_statement(token_list, logger=None):
	token_list = [token for token in token_list if not token.is_whitespace]
	tables = []

	if token_list[1].is_keyword:
		if token_list[1].value.upper() == 'IGNORE':
			token_list = token_list[0:1] + token_list[2:]

	if token_list[1].is_keyword:
		if token_list[1].value.upper() == 'INTO':
			tables = extract_insert_table_identifier(token_list[2:3], logger=logger)
		else:
			# print("analyze_insert_statement does not handle")
			pass
	else:
		tables = extract_insert_table_identifier(token_list[1:2], logger=logger)

	dml_counter = 0
	for token in token_list:
		if token.ttype == sqlparse.tokens.Token.Keyword.DML:
			dml_counter += 1
	if dml_counter > 1:
		return [], {}

	# ZY: build dict{column: value}
	# looking for the (columns) to operate on
	start = 0
	end = 0
	column_list = []
	for tokens in token_list:
		for token in list(tokens.flatten()):
			# print(token)
			# print(token.ttype)
			
			if(str(token.ttype) == "Token.Punctuation" and token.value == "("):
				start = 1
			if(str(token.ttype) == "Token.Punctuation" and token.value == ")"):
				end = 1
			if(end == 1):
				break
			elif(start == 1):
				if(str(token.ttype) != "Token.Punctuation" and not token.is_whitespace):
					column_list.append(remove_symbols(token.value)) # token.value is a str type
			else:
				continue

	# # looking for VALUES (values)
	start = 0
	end = 0
	value_list = []
	for tokens in token_list:
		for token in list(tokens.flatten()):
			if(str(token.ttype) == "Token.Keyword" and (token.value == "VALUES" or token.value == "values")):
				start = 1
				continue
			if(start == 1):
				if(str(token.ttype) == "Token.Punctuation" and token.value == ")"):
					end = 1
				if(end == 1):
					break
				else:
					if(str(token.ttype) != "Token.Punctuation" and not token.is_whitespace):
						value_list.append(remove_symbols(token.value))
	ret = MyDict()
	# assert(len(column_list) == len(value_list)), "analyze_insert_statement INSERT query wrong"
	for i in range(len(column_list)):
		ret.add(column_list[i], value_list[i])
	temp = []
	for table in tables:
		temp.append(remove_symbols(table))
	tables = temp
	# print(tables)
	# print(ret)
	return tables, [ret]

def analyze_delete_statement(token_list, logger=None):
	token_list = [token for token in token_list if not token.is_whitespace]
	uses = []
	defines = []
	tables = []
	
	pos_from = position_of_keyword(token_list, 'FROM')
	pos_where = position_of_keyword(token_list, 'WHERE')
	if pos_where is not None:
		tables = analyze_identifier_list(token_list[pos_from+1:], keywords_are_identifiers=True, logger=logger)
	else:
		tables = analyze_identifier_list(token_list[pos_from+1:], keywords_are_identifiers=True, logger=logger)
		uses = ["*"]

	#ZY:
	# looking for the WHERE clause
	column_list = []
	value_list = []
	for p in token_list:
		if(str(p.__class__) == "<class 'sqlparse.sql.Where'>"):
			where_list = list(p.flatten())
			where_list = [token for token in where_list if not token.is_whitespace]
			for token in where_list:
				if token.ttype == sqlparse.tokens.Token.Keyword.DML:
					# we do not handle subquery situations
					# print("we do not handle subquery in delete")
					return [], {}
			for token in where_list:
				if(str(token.ttype) == "Token.Operator.Comparison"):
					comparison_index = where_list.index(token)
					temp_column_token = where_list[comparison_index-1]
					temp_value_token = where_list[comparison_index+1]
					if(str(temp_column_token.ttype) ==  "Token.Punctuation"):
						temp_column_token = where_list[comparison_index-1]
					if(str(temp_value_token.ttype) ==  "Token.Punctuation"):
						temp_value_token = where_list[comparison_index+1]

					column_list.append(remove_symbols(temp_column_token.value))
					value_list.append(remove_symbols(temp_value_token.value))

				if(token.is_keyword and (token.value.upper() == "IN")):
					in_index = where_list.index(token)
					temp_value = []
					for i in range(in_index+1, len(where_list)):
						if(where_list[i].value == ")"):
							break
						if(str(where_list[i].ttype) == "Token.Punctuation" and where_list[i].value != ")"):
							continue
						else:
							temp_value.append(where_list[i].value)
					if(where_list[in_index-1].is_whitespace):
						if(where_list[in_index-2].is_keyword):
							temp_column_token = where_list[in_index-3]
						else:
							temp_column_token = where_list[in_index-2]
					else:
						temp_column_token = where_list[in_index-1]

					column_list.append(remove_symbols(temp_column_token.value))
					value_list=temp_value
	ret = MyDict()
	assert(len(column_list) == len(value_list)), "analyze_insert_statement INSERT query wrong"
	for i in range(len(column_list)):
		ret.add(column_list[i], value_list[i])
	temp = []
	for table in tables:
		temp.append(remove_symbols(table))
	tables = temp
	# print(tables)
	# print(ret)
	return tables, [ret]

class QueryParser:
	def __init__(self, query_string, schema_dict):
		self.__query = sqlparse.format(query_string, keyword_case="upper", identifier_case="lower", strip_comments=True)
		self.stmt = sqlparse.parse(self.__query)[0]

	def parse(self):
		stmt = self.stmt
		if stmt.get_type() == 'SELECT':
			self.__type = "SELECT"
			self.__table_name, self.__dict = analyze_select_statement(stmt.tokens, logger=None)
		elif stmt.get_type() == "INSERT":
			self.__type = "INSERT"
			self.__table_name, self.__dict = analyze_insert_statement(stmt.tokens, logger=None)
		elif stmt.get_type() == "DELETE":
			self.__type = "DELETE"
			self.__table_name, self.__dict = analyze_delete_statement(stmt.tokens, logger=None)
		elif stmt.get_type() == "UPDATE":
			self.__type = "UPDATE"
			self.__table_name, self.__dict, self.__set_dict = analyze_update_statement(stmt.tokens, self.__query, logger=None)

	def get_query_type(self):
		try:
			return self.__type
		except:
			return None

	def get_query_table_name(self):
		try:
			return self.__table_name
		except:
			return None

	def get_query_dict(self):
		try:
			return self.__dict
		except:
			return None

	def get_set_dict(self):
		try:
			return self.__set_dict
		except:
			return None


# testing part
# query_string = "SELECT * FROM mdl_context WHERE contextlevel = '10'"
# parser = QueryParser(query_string, None)
# parser.parse()
# print(parser.get_query_type())
# print(parser.get_query_table_name())
# print(parser.get_query_dict())
# stmt = sqlparse.parse(query_string)[0]
# print(stmt)
# for token in stmt.tokens:
# 	print("--------------------")
# 	print(token)
# 	print(type(token))
# 	print(token.value)
# if stmt.get_type() == 'SELECT':
# 	print("analyzing select")
# 	analyze_select_statement(stmt.tokens, logger=None)
# elif stmt.get_type() == "INSERT":
# 	print("analyzing insert")
# 	analyze_insert_statement(stmt.tokens, logger=None)
# elif stmt.get_type() == "DELETE":
# 	print("analyzing delete")
# 	analyze_delete_statement(stmt.tokens, logger=None)
# elif stmt.get_type() == "UPDATE":
# 	print("analyzing update")
# 	analyze_update_statement(stmt.tokens, query_string, logger=None)