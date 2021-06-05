from structures.basics.FileReaderV2 import *
from structures.basics.MyDict import *
from structures.RequestWithTokens import *
import re

class ControlDependencyFinder:
	def __init__(self, prune_log_path):
		self.__read_prune_file(prune_log_path)
		self.__request_list = []
		self.__unrace_request = set()
		self.__unrace_request_pairs = []
		self.__return_list = []
		self.__unrace_request_chain = []
		self.__unrace_request_ids = []
		self.__parse_prune_file()
		self.__find_unrace_request_pairs()
		self.__prune_dup_req_pairs()
		self.__link_unrace_requests()
		self.__append_ajax_to_group()
		self.__append_single_request_to_group()

		for chain in self.__unrace_request_chain:
			temp = []
			for stmt in chain:
				temp.append(stmt.get_request_id())
			self.__unrace_request_ids.append(temp)

		# print("The groups found by Control dependency")
		# print(self.__unrace_request_ids)
		# print(len(self.__unrace_request_ids))


	def __read_prune_file(self, prune_log_path):
		logfile = prune_log_path
		fr = FileReader(logfile)
		fr.parse()
		self.__lines = fr.get_content()

	def __parse_prune_file(self):
		counter = 0
		for line in self.__lines:
			# search for the request id
			if("RequestID" in line):
				current_request_id = line["RequestID"]
				if(len(self.__request_list) == 0):
					req = RequestWithTokens()
					req.set_request_id(current_request_id)
					self.__request_list.append(req)
				else:
					new_req = 1
					for request in self.__request_list:
						if(request.get_request_id() == current_request_id):
							new_req = 0
							break
						else:
							new_req = 1
					if(new_req):
						counter += 1
						req = RequestWithTokens()
						req.set_request_id(current_request_id)
						self.__request_list.append(req)

				if("URL" in line):
					url = line["URL"]
					for request in self.__request_list:
						if(request.get_request_id() == current_request_id):
							request.set_url(url)

				if("Received Token" in line):
					rec_token = line["Received Token"]
					for request in self.__request_list:
						if(request.get_request_id() == current_request_id):
							request.set_rec_token(rec_token)

				if("Generated Token" in line):
					gen_token = line["Generated Token"]
					for request in self.__request_list:
						if(request.get_request_id() == current_request_id):
							request.set_gen_token(gen_token)

				if("Redirect Token" in line):
					red_token = line["Redirect Token"]
					for request in self.__request_list:
						if(request.get_request_id() == current_request_id):
							request.set_red_token(red_token)
		# print("@@@@@@@ num of requests in ControlDependencyFinder.py")
		# print(counter)

	def __find_unrace_request_pairs(self):
		for req1 in self.__request_list:
			for req2 in self.__request_list:
				if(req1.get_request_id() == req2.get_request_id()):
					continue
				else:
					if(req1.get_rec_token() and req2.get_gen_token() and req1.get_rec_token() == req2.get_gen_token()):
						temp = []
						temp.append(req1)
						temp.append(req2)
						if(temp not in self.__unrace_request_pairs):
							self.__unrace_request_pairs.append(temp)
					if(req1.get_gen_token() and req2.get_rec_token() and req1.get_gen_token() == req2.get_rec_token()):
						temp = []
						temp.append(req1)
						temp.append(req2)
						if(temp not in self.__unrace_request_pairs):
							self.__unrace_request_pairs.append(temp)
					if(req1.get_rec_token() and req2.get_red_token() and req1.get_rec_token() == req2.get_red_token()):
						temp = []
						temp.append(req1)
						temp.append(req2)
						if(temp not in self.__unrace_request_pairs):
							self.__unrace_request_pairs.append(temp)
					if(req1.get_red_token() and req2.get_rec_token() and req1.get_red_token() == req2.get_rec_token()):
						temp = []
						temp.append(req1)
						temp.append(req2)
						if(temp not in self.__unrace_request_pairs):
							self.__unrace_request_pairs.append(temp)

	def __prune_dup_req_pairs(self):
		pairs = self.__unrace_request_pairs
		for pair1 in self.__unrace_request_pairs:
			for pair2 in self.__unrace_request_pairs:
				if(pair1[0] == pair2[1] and pair1[1] == pair2[0]):
					pairs.remove(pair2)
		self.__unrace_request_pairs = pairs

	def __check_if_share_common(self, result, pair):
		for stmt1 in result:
			for stmt2 in pair:
				if(stmt1==stmt2):
					return True
		return False

	def __link_unrace_requests(self):
		result = []
		index1 = 0
		while(index1 < len(self.__unrace_request_pairs)):
			index2 = index1+1
			if(self.__unrace_request_pairs[index1][0] not in result):
				result.append(self.__unrace_request_pairs[index1][0])
				result.append(self.__unrace_request_pairs[index1][1])
			index1 += 1
			if(index1 == len(self.__unrace_request_pairs)):
				self.__unrace_request_chain.append(result)
			
			while(index2 < len(self.__unrace_request_pairs)):
				if(self.__check_if_share_common(result, self.__unrace_request_pairs[index2])):
					in_first = set(result)
					in_second = set(self.__unrace_request_pairs[index2])
					in_second_not_in_first = in_second - in_first
					result += list(in_second_not_in_first)
				else:
					if(result):
						index1 = index2
						self.__unrace_request_chain.append(result)
						result = []
						break
				index2 += 1

	def __append_ajax_to_group(self):
		result = []
		index1 = 0
		while(index1 < len(self.__request_list)):
			index1 += 1
			if(index1 != len(self.__request_list)):
				# find the request that ajax request should be append to
				if(self.__request_list[index1-1].get_url().find('jax') == -1 and \
					self.__request_list[index1].get_url().find('jax') != -1):
					result.append(self.__request_list[index1-1])
					# print(self.__request_list[index1-1].get_request_id())
					index2 = index1
					while(index2 < len(self.__request_list)):
						if(self.__request_list[index2].get_url().find('jax') != -1):

							result.append(self.__request_list[index2])
						else:
							if(len(result) > 1):
								self.__unrace_request_chain.append(result)
							result = []
							break
						index2 += 1
					index1 = index2
		# loop through self.__unrace_request_chain, combine those share a common request
		temp = []
		to_remove = []
		for chain1 in self.__unrace_request_chain:
			for chain2 in self.__unrace_request_chain:
				if(chain1 == chain2):
					continue
				for req1 in chain1:
					for req2 in chain2:
						if(req1 == req2):
							mylist = chain1 + chain2
							if(chain1 not in to_remove):
								to_remove.append(chain1)
							if(chain2 not in to_remove):
								to_remove.append(chain2)
							# myset = set(mylist)
							# newchain = list(myset)
							newchain = mylist
							if(newchain not in temp):
								temp.append(newchain)
							break
			if(chain1 not in temp):
				temp.append(chain1)
		for chain in to_remove:
			temp.remove(chain)
		self.__unrace_request_chain = temp

	def __append_single_request_to_group(self):
		temp = self.__unrace_request_chain
		unrace_requests = []
		for chain in temp:
			for request in chain:
				if(request not in unrace_requests):
					unrace_requests.append(request)
		for request in self.__request_list:
			if(request not in unrace_requests):
				self.__unrace_request_chain.append([request])

	def get_request_groups(self):
		return self.__unrace_request_ids

	def get_request_list(self):
		return self.__request_list

#test
# control_log_file = "../logs/11073_token.log"
# cfinder = ControlDependencyFinder(control_log_file)
