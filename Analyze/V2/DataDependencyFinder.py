class DataRequest:
	def __init__(self, table, column, value, query_type, req_id):
		self.__table = table
		self.__column = column
		self.__value = value
		self.__type = query_type
		self.__id = req_id

	def get_table(self):
		return self.__table

	def get_column(self):
		return self.__column

	def get_value(self):
		return self.__value

	def get_type(self):
		return self.__type

	def get_id(self):
		return self.__id


class DataDependencyFinder:
	def __init__(self, instr_set, auto_dict):
		self.__insert_req = []
		self.__select_req = []
		self.__update_req = []
		self.__instr_set = instr_set
		self.__search_insert(instr_set, auto_dict)
		self.__search_select(instr_set, auto_dict)
		self.__search_update(instr_set, auto_dict)
		self.__data_dependent_requests = []
		self.__find_dependency()
		# print(len(self.__data_dependent_requests))

	def get_dependent_requests(self):
		return self.__data_dependent_requests

	def __find_dependency(self):
		# find INSRET and SELECT
		for insert in self.__insert_req:
			for select in self.__select_req:
				if(insert.get_id() != select.get_id()):
					if(insert.get_table() == select.get_table() and \
					   insert.get_column() == select.get_column() and \
					   insert.get_value() == select.get_value()):
						result = [insert.get_id(), select.get_id()]
						if(result not in self.__data_dependent_requests):
							self.__data_dependent_requests.append(result)
		# print("find insert and select")
		# print(len(self.__data_dependent_requests))
		# find UDPATE and SELECT
		# for update in self.__update_req:
		# 	for select in self.__select_req:
		# 		if(update.get_id() != select.get_id()):
					# if(update.get_table()[0][0:-1] == select.get_table() and \
					#    update.get_column() == select.get_column() and \
					#    update.get_value() == select.get_value()):
					# 	result = [update.get_id(), select.get_id()]
					# 	if(result not in self.__data_dependent_requests):
					# 		self.__data_dependent_requests.append(result)
		for instr1 in self.__instr_set:
			if("post_status = 'trash'" in instr1.get_query() and instr1.get_query_type() == "SELECT"):
				select = instr1
				for instr2 in self.__instr_set:
					if("`post_status` = 'trash'" in instr2.get_query() and instr2.get_query_type() == "UPDATE"):
						update = instr2
						result = [instr2.get_request_id(), instr1.get_request_id()]
						if(result not in self.__data_dependent_requests):
							self.__data_dependent_requests.append(result)
		# print("find update and select")
		# print(len(self.__data_dependent_requests))
		# for instr1 in self.__instr_set:
		# 	if instr1.get_query_type() == "SELECT":
		# 		for instr2 in self.__instr_set:
		# 			if instr2.get_query_type() == "UPDATE":
		# 				if instr1.get_request_id() != instr2.get_request_id() and \
		# 					instr1.get_table_name() == instr2.get_table_name():
		# 					dicts1 = instr1.get_dict()
		# 					dict2 = instr2.get_set_dict()
		# 					# print(dict2)
		# 					for dict1 in dicts1:
		# 						for key1 in dict1:
		# 							for key2 in dict2:
		# 								# print(key1)
		# 								# print(key2)
		# 								if key1 == key2:
		# 									if type(dict1[key1]) is list:
		# 										v1 = self.__sanitize(dict1[key1][0])
		# 									else:
		# 										v1 = self.__sanitize(dict1[key1])
		# 									if type(dict1[key1]) is list:
		# 										v2 = self.__sanitize(dict2[key2][0])
		# 									else:
		# 										v2 = self.__sanitize(dict2[key2])
		# 									if  v1 == v2:
		# 										# print("FIND")
		# 										result = [instr2.get_request_id(), instr1.get_request_id()]
		# 										if(result not in self.__data_dependent_requests):
		# 											self.__data_dependent_requests.append(result)

	def __sanitize(self, value):
		return value.replace("'", "")

	def __search_insert(self, instr_set, auto_dict):
		for instr in instr_set:
			if(instr.get_query_type() == "INSERT"):
				instr2 = instr_set[instr_set.index(instr)+1]
				if(instr2.get_insert_id()):
					table_name = instr.get_table_name()[0]
					# print(table_name)
					insert_id = instr2.get_insert_id()
					for key in auto_dict:
						if(key == table_name):
							if(auto_dict[key][0]):
								data_req = DataRequest(table_name, auto_dict[key][0][0], insert_id, "INSERT", instr.get_request_id())
								if(data_req not in self.__insert_req):
									self.__insert_req.append(data_req)
		# print(len(self.__insert_req))

	def __search_select(self, instr_set, auto_dict):
		for instr in instr_set:
			if(instr.get_query_type() == "SELECT"):
				if not instr.get_table_name():
					continue
				table_names = instr.get_table_name()
				'''
				Search for SELECT that have data dependency with INSERT
				'''
				for table_name in table_names:
					for key1 in auto_dict:
						if(key1 == table_name):
							if not auto_dict[key1][0]:
								continue
							if(instr.get_dict()):
								temp = instr.get_dict()[0]
								for key2 in temp:
									if(auto_dict[key1][0][0] == key2):
										column = key2
										value = temp[key2]
										if(len(value) > 1):
											continue
										data_req = DataRequest(table_name, column, self.__sanitize(value[0]), "SELECT", instr.get_request_id())
										if(data_req not in self.__select_req):
											self.__select_req.append(data_req)
											# print(instr.get_request_id())

					'''
					check specific query, need to add more later
					Search for SELECT that have data dependency with UPDATE
					TODO
					'''
					for key in instr.get_dict():
						table_name = instr.get_table_name()
						if(key == "post_status"):
							column = key
							value = instr.get_dict()[key]
							if(len(value) > 1):
								continue
							if(instr.get_dict()[key][0] == "'trash'"):
								# print(value[0])
								data_req = DataRequest(table_name, column, self.__sanitize(value[0]), "SELECT", instr.get_request_id())
								if(data_req not in self.__insert_req):
											self.__select_req.append(data_req)
		# print(len(self.__select_req))

	def __search_update(self, instr_set, auto_dict):
		for instr in instr_set:
			if(instr.get_query_type() == "UPDATE"):
				if not instr.get_table_name():
					continue
				table_name = instr.get_table_name()[0]

				'''
				check specific query, need to add more later
				Search for UPDATE that have data dependency with SELECT
				TODO
				'''
				if("`post_status` = 'trash'" in instr.get_query()):
					table_name = instr.get_table_name()
					column = "post_status"
					value = "'trash'"
					data_req = DataRequest(table_name, column, self.__sanitize(value), "UPDATE", instr.get_request_id())
					if(data_req not in self.__update_req):
						self.__update_req.append(data_req)
						# print(instr.get_request_id())

		# print(len(self.__update_req))