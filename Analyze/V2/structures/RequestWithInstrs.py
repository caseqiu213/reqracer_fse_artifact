class RequestWithInstrs:
	def __init__(self, instr_set, request_id):
		self.__instr_set = instr_set
		self.__request_id = request_id
		self.__instrs = []
		self.__duplicate_need = 0

		self.__build()

	def __build(self):
		for instr in self.__instr_set:
			if(instr.get_request_id() == self.__request_id):
				self.__instrs.append(instr)
				if(instr.get_query_type() == "INSERT"):
					self.__duplicate_need = 1
				if("ON DUPLICATE KEY" in instr.get_query()):
					self.__duplicate_need = 0
				if(instr.get_table_name() and "wp_postmeta" in instr.get_table_name()):
					if("_edit_last" in instr.get_query() or "_edit_lock" in instr.get_query()):
						self.__duplicate_need = 0

	def get_request_id(self):
		return self.__request_id

	def get_instrs(self):
		return self.__instrs

	def get_duplicate_need(self):
		return self.__duplicate_need

	def set_request_id(self):
		self.__request_id += "1"