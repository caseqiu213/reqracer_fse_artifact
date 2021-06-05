class RacingRequestPairQuery:
	def __init__(self, request1, request2, instrs):
		self.__pair = [request1, request2]
		self.__instrs = instrs

	def get_racing_request_id_pair(self):
		return self.__pair

	def get_racing_instrs(self):
		return self.__instrs

	def update(self, instrs):
		for i in instrs:
			self.__instrs.append(i)
