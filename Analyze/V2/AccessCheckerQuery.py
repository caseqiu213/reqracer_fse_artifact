from structures.RacingRequestPairQuery import *
class AccessCheckerQuery:
	def __init__(self, requests_with_queries, schema_dict):
		self.__requests = requests_with_queries
		self.__racing_reqeust_pairs = []
		self.__schema_dict = schema_dict

		self.__find_pair()

	def __find_pair(self):
		# print(len(self.__requests))
		racing_request_ids = []
		for request1 in self.__requests:
			for request2 in self.__requests:
				if(request1.get_request_id() != request2.get_request_id()):
					# assert request1.get_request_id() != request2.get_request_id(), "find_pair needs work0"
					instrs1 = request1.get_instrs()
					instrs2 = request2.get_instrs()
					racing_instrs = []
					for instr1 in instrs1:
						for instr2 in instrs2:
							if(instr1.get_request_id() != instr2.get_request_id()):
								# if True means having conflicting access
								if(self.__check_access(instr1, instr2)):
									if([instr1, instr2] not in racing_instrs and [instr2, instr1] not in racing_instrs):
										# make sure instr1 is not an R
										if instr1.get_type() == "R":
											instr1, instr2 = instr2, instr1
										assert instr1.get_request_id() != instr2.get_request_id(), "find_pair needs work"
										racing_instrs.append([instr1, instr2])
										# if(instr1.get_request_id() == "XdXkjT6jvg6BwEALh8OxVwAAAJQ" and instr2.get_request_id() == "XdXklT6jvg6BwEALh8OxWgAAAJU"):
										# 	print("======")
										# 	print(instr1.get_query())
										# 	print(instr2.get_query())
					if(len(racing_instrs)):
						# print(request1.get_request_id())
						# print(request2.get_request_id())
						# print(len(racing_instrs))
						# print("============")
						racing_request_pair = RacingRequestPairQuery(request1.get_request_id(), 
											request2.get_request_id(), racing_instrs)
						racing_instrs = []
						if(racing_request_pair not in self.__racing_reqeust_pairs):
						# req1_id = request1.get_request_id()
						# req2_id = request2.get_request_id()
						# if[req1_id, req2_id] not in racing_request_ids and [req2_id, req1_id] not in racing_request_ids:
							self.__racing_reqeust_pairs.append(racing_request_pair)
							# racing_request_ids.append([req1_id, req2_id])
						# else:
						# 	# print("duplicate")
						# 	for i in self.__racing_reqeust_pairs:
						# 		if i.get_racing_request_id_pair() == [req1_id, req2_id] or \
						# 			i.get_racing_request_id_pair() == [req2_id, req1_id]:
						# 			# print("update")
						# 			i.update(racing_instrs)
		# print("The number of racing request pairs are ")
		# print(len(self.__racing_reqeust_pairs))

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

	def get_racing_request_pairs(self):
		return self.__racing_reqeust_pairs

	def remove_symbols(self, name):
		name = name.replace("'", "")
		return name