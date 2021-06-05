import os
from generate_replay_log import *

print("\nStart in generate_queries.py")
print("\nGenerate queries for non-dup racing requests:")
requests, request_order = get_requests_with_instr()

racing_request_pairs = get_racing_request_pairs()
print(racing_request_pairs)

class QueryChecker:
	def __init__(self, req1, req2, schema_dict):
		self.__req1 = req1
		self.__req2 = req2
		self.__schema_dict = schema_dict
		self.__queries = []
		self.find()

	def find(self):
		req1 = self.__req1
		req2 = self.__req2
		instrs1 = req1.get_instrs()
		instrs2 = req2.get_instrs()
		racing_instrs = []
		for instr1 in instrs1:
			for instr2 in instrs2:
				if(self.__check_access(instr1, instr2)):
					if([instr1, instr2] not in racing_instrs and [instr2, instr1] not in racing_instrs):
						racing_instrs.append([instr1, instr2])
		# print(len(racing_instrs))

		result = []
		for pair in racing_instrs:
			for instr1 in instrs1:
				if instr1 == pair[0]:
					continue
				if(self.__check_access(instr1, pair[0])):
					temp = pair
					temp.append(instr1)
					if temp[0].get_query_id() > temp[2].get_query_id():
						temp[0], temp[2] = temp[2], temp[0]
					if temp not in result:
						result.append(temp)
		print(len(result))

		# for i in result:
		# 	print(request_order.index(i[0].get_request_id()))
		# 	print(i[0].get_query_id())
		# 	print(request_order.index(i[1].get_request_id()))
		# 	print(i[1].get_query_id())
		# 	print(request_order.index(i[2].get_request_id()))
		# 	print(i[2].get_query_id())
		# 	print("**")

		self.__queries = result

	def __check_table_name(self, instr1, instr2):
		table1 = instr1.get_table_name()
		table2 = instr2.get_table_name()
		if not table1:
			return False
		if not table2:
			return False
		for t1 in table1:
			for t2 in table2:
				if("session" in t1 or "session" in t2):
					continue
				if(t1 == "mdl_user_preferences" or t2 == "mdl_user_preferences"):
					continue
				if(t1 == "watchdog" or t2 == "watchdog"):
					continue
				if(t1 == "mdl_log" or t2 == "mdl_log"):
					continue
				if(t1 == "cache_bootstrap" or t2 == "cache_bootstrap"):
					continue
				if(t1 == t2):
					return True
		return False

	def __check_select_all(self, instr):
		query = instr.get_query()
		if("SELECT" in query and "WHERE" not in query and "* FROM" in query):
			return True
		elif("SELECT" in query and "WHERE" not in query and "HAVING" not in query):
			return True
		else:
			return False

	def __check_dict(self, instr1, instr2):
		dicts1 = instr1.get_dict()
		dicts2 = instr2.get_dict()
		if("ON DUPLICATE KEY" in instr1.get_query() or "ON DUPLICATE KEY" in instr2.get_query()):
			return False
		if dicts1 == [] or dicts2 == []:
			return False
		# assert len(dict1)==len(dict2)==1, "check query parser return"
		for dict1 in dicts1:
			for dict2 in dicts2:
				table_names = instr1.get_table_name()
				for table_name in table_names:
					if(table_name in self.__schema_dict):
						unique_keys = self.__schema_dict[table_name]
						if(instr1.get_query_type()=="INSERT" and instr2.get_query_type()=="INSERT"):
							flag = 1
							for unique_key in unique_keys[0]:
								if(unique_key in dict1 and unique_key in dict2):
									if(dict1[unique_key] == dict2[unique_key]):
										return True
								# else:
								# 	flag &= 0

							if("ON DUPLICATE KEY" in instr1.get_query() or "ON DUPLICATE KEY" in instr2.get_query()):
								return False
								
							# if(flag == 0):
							# 	return False
				res = False
				# if(instr1.get_request_id() == "XsiHoLBaRkqGaqJiwsdChAAAAIM" and instr2.get_request_id() == "2216"):
				# 	if(instr1.get_type() == "A" and instr2.get_type() == "A"):
				# 		print("91")
				for key1 in dict1:
					for key2 in dict2:
						if(key1 == key2):
							values1 = dict1[key1]
							values2 = dict2[key2]
							for value1 in values1:
								for value2 in values2:
									if(self.remove_symbols(value1) == self.remove_symbols(value2)):
										res = True
										return res
				return res

	def __check_access(self, instr1, instr2):
		if(instr1.get_type() == "W" \
			or instr1.get_type() == "A" \
			or instr1.get_type() == "D"):
			if("ON DUPLICATE KEY" in instr1.get_query()):
				return False
			table = instr1.get_table_name()
			if(table and "wp_postmeta" in table):
				if("_edit_last" in instr1.get_query() or "_edit_lock" in instr1.get_query()):
					return False

		if(instr2.get_type() == "W" \
			or instr2.get_type() == "A" \
			or instr2.get_type() == "D"):
			if("ON DUPLICATE KEY" in instr1.get_query()):
				return False
			table = instr2.get_table_name()
			if(table and "wp_postmeta" in table):
				if("_edit_last" in instr2.get_query() or "_edit_lock" in instr2.get_query()):
					return False

		if not (instr1.get_type()=="R" and instr2.get_type()=="R"):
			if(self.__check_table_name(instr1, instr2)):
				# if(instr1.get_request_id() == "XdXkjT6jvg6BwEALh8OxVwAAAJQ" and instr2.get_request_id() == "XdXklT6jvg6BwEALh8OxWgAAAJU"):
				# 	if(instr1.get_type() == "A" and instr2.get_type() == "W"):
				# 		print(instr1.get_query())
				# 		print(instr2.get_query())
				# 		print(self.__check_dict(instr1, instr2))
				# 		print(instr1.get_dict())
				# 		print(instr2.get_dict())
				if(instr1.get_type() == "R" and self.__check_select_all(instr1)):
					return True
				if(instr2.get_type() == "R" and self.__check_select_all(instr2)):
					return True
				# general check
				if(instr1.get_type() == "R" and instr2.get_type()!="R"):
					instr1, instr2 = instr2, instr1
				if(self.__check_dict(instr1, instr2)):
					# if(instr1.get_request_id() == "XsiHoLBaRkqGaqJiwsdChAAAAIM" and instr2.get_request_id() == "2216"):
					# 	if(instr1.get_type() == "A" and instr2.get_type() == "A"):
					# 		print("Double check")
					return True

	def remove_symbols(self, name):
		name = name.replace("'", "")
		return name

	def get_queries(self):
		return self.__queries

def format(query):
		query = query.replace("'", "")
		query = query.replace("`", "")
		query = re.sub(' +', ' ', query)
		# INSERT query has time-sensitive values. truncate the query string
		# if query.startswith("INSERT"):
		# 	return query.split("VALUES")[0] + query.split("VALUES")[1].split(",")[0]
		return query

queries_in_request_pairs = []
idx = 0

bug_path = '../../Replay/' + str(bug)
if not os.path.exists(bug_path):
    os.makedirs(bug_path)

while idx < len(racing_request_pairs):
	pair = racing_request_pairs[idx]
	req1 = requests[pair[0]]
	req2 = requests[pair[1]]
	# print(request_order.index(req1.get_request_id()))
	# print(request_order.index(req2.get_request_id()))
	query_checker = QueryChecker(req1, req2, db_dict)
	result = query_checker.get_queries()
	queries_in_request_pairs.append(result)

	print(racing_request_pairs[idx])
	print(sorted(log1s[idx]))
	print(sorted(log2s[idx]))

	counter = 0
	for i in result:
		filename = bug_path + \
		"/req_" + str(request_order.index(result[0][0].get_request_id())) + \
		"_req_" + str(request_order.index(result[0][1].get_request_id())) + \
		"_replay_queries_" + str(counter) + ".txt"

		# print(filename)
		f = open(filename,"w+")
		f.write(str(sorted(log1s[idx]).index(request_order.index(i[0].get_request_id())) + 1) + "\n")
		f.write(format(i[0].get_query()) + "\n")
		f.write(str(sorted(log2s[idx]).index(request_order.index(i[1].get_request_id())) + 1) + "\n")
		f.write(format(i[1].get_query()) + "\n")
		f.write(str(sorted(log1s[idx]).index(request_order.index(i[2].get_request_id())) + 1) + "\n")
		f.write(format(i[2].get_query()) + "\n")
		f.close()
		counter += 1
	idx += 1

print("\nGenerate queries for dup racing requests:")
racing_request_pairs_dup = get_racing_request_pairs_dup()
print(racing_request_pairs_dup)

queries_in_request_pairs_dup = []
idx = 0

while idx < len(racing_request_pairs_dup):
	pair = racing_request_pairs_dup[idx]
	req1 = requests[pair[0]]
	req2 = requests[pair[0]]

	query_checker_dup = QueryChecker(req1, req2, db_dict)
	result_dup = query_checker_dup.get_queries()
	queries_in_request_pairs_dup.append(result_dup)

	print(racing_request_pairs_dup[idx])
	print(sorted(log1s_dup[idx]))
	print(sorted(log2s_dup[idx]))

	counter = 0
	for i in result_dup:
		filename = bug_path + \
		"/dup_req_" + str(request_order.index(result_dup[0][0].get_request_id())) + \
		"_req_" + str(request_order.index(result_dup[0][1].get_request_id())) + \
		"_replay_queries_" + str(counter) + ".txt"

		# print(filename)
		f = open(filename,"w+")
		f.write(str(sorted(log1s_dup[idx]).index(request_order.index(i[0].get_request_id())) + 1) + "\n")
		f.write(format(i[0].get_query()) + "\n")
		f.write("1" + "\n")
		f.write(format(i[1].get_query()) + "\n")
		f.write(str(sorted(log1s_dup[idx]).index(request_order.index(i[2].get_request_id())) + 1) + "\n")
		f.write(format(i[2].get_query()) + "\n")
		f.close()
		counter += 1
	idx += 1
