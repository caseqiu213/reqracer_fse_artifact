class RequestWithTokens:
	def __init__(self):
		self.__request_id = ""
		self.__rec_token = ""
		self.__url = ""
		self.__gen_token = ""
		self.__red_token = ""

	def set_request_id(self, request_id):
		self.__request_id = request_id

	def get_request_id(self):
		return self.__request_id

	def set_rec_token(self, rec_token):
		if(rec_token == "null"):
			self.__rec_token = ""
		else:
			self.__rec_token = rec_token

	def get_rec_token(self):
		return self.__rec_token

	def set_url(self, url):
		self.__url = url

	def get_url(self):
		return self.__url

	def set_gen_token(self, gen_token):
		self.__gen_token = gen_token

	def get_gen_token(self):
		return self.__gen_token

	def set_red_token(self, red_token):
		self.__red_token = red_token

	def get_red_token(self):
		return self.__red_token