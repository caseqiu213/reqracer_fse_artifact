# for data dependency
from DataDependencyFinder import *
# for control dependency
from ControlDependencyFinder import *

from itertools import combinations

class DependencyGraphBuilder:
	def __init__(self, control_log_file, instr_set, auto_dict, request_order):

		self.__racing_request_groups = []
		self.__spk_edges = []

		control_dependency_finder = ControlDependencyFinder(control_log_file)
		request_groups = control_dependency_finder.get_request_groups()
		temp = []
		for i in request_groups:
			if set(i) not in temp:
				temp.append(set(i))
		# print(len(temp))
		request_groups = []
		for i in temp:
			request_groups.append(list(i))

		# print("Number of groups after Control Dependency:")
		# print(len(request_groups))
		# for i in request_groups:
		# 	print(i)

		self.__CD_groups = request_groups

		'''Control dependency ends here'''


		# calculate how many request pairs are pruned by catching control dependency
		# pruned_by_control = 0
		# for group in request_groups:
		# 	pruned_by_control += int(len(group) * (len(group)-1)/2)
		# print("Number of request pairs pruned by Control Dependency(This value is calculated by combination):")
		# print(pruned_by_control)

		# generate group pairs
		comb = combinations(request_groups, 2)
		potential_racing_request_groups = list(comb)

		# print("Number of group pairs to check Data Dependency:")
		# print(len(potential_racing_request_groups))

		# check data dependency between each pair
		
		finder = DataDependencyFinder(instr_set, auto_dict)
		data_dependent_requests_ids = finder.get_dependent_requests()
		# print(len(data_dependent_requests_ids))
		# print(data_dependent_requests_ids)
		self.__sanity_check(data_dependent_requests_ids, request_order)

		prune = []
		for data in data_dependent_requests_ids:
			for requests in potential_racing_request_groups:
				if data[0] in requests[0] and data[1] in requests[1]:
					if requests not in prune:
						prune.append(requests)
				# if(data[1] in requests[0] and data[0] in requests[1]):
				# 	if(requests not in prune):
				# 		prune.append(requests)

		# print("Number of group pairs pruned by Data Dependency:")
		# print(len(prune))

		self.__DD_groups = prune

		# calculate how many request pairs pruned by data dependency
		# pruned_by_data = 0
		# for group in prune:
		# 	pruned_by_data += int(len(group[1]) * len(group[0])/2)
		# print("Number of request pairs pruned by Data Dependency:(This value is calculated by combination)")
		# print(pruned_by_data)
		self.__racing_request_groups = [x for x in potential_racing_request_groups if x not in prune]

		# get the remaining racing request groups to check conflict accesses
		# for i in potential_racing_request_groups:
		# 	if(i not in prune):
		# 		print(i)
		self.__modified_DD=[]
		self.__modified_check(prune, data_dependent_requests_ids, request_order)

	def __modified_check(self, data_groups, data_dependent_requests_ids, request_order):
		data_group_id=[]
		for pair in data_groups:
			temp1=[]
			temp2=[]
			for i in pair[0]:
				temp1.append(request_order.index(i))
			for j in pair[1]:
				temp2.append(request_order.index(j))
			data_group_id.append((sorted(temp1), sorted(temp2)))
		# print("*********************  in progress still ***********************")
		# print(data_group_id)
		# print(data_dependent_requests_ids)
		dependent_id=[]
		for id_pair in data_dependent_requests_ids:
			dependent_id.append((request_order.index(id_pair[0]), request_order.index(id_pair[1])))
		# print(dependent_id)
		result=[]
		for group_pair in data_group_id:
			for req_pair in dependent_id:
				if req_pair[0] in group_pair[0] and req_pair[1] in group_pair[1]:
					prev=[]
					idx=0
					while(idx<=group_pair[0].index(req_pair[0])):
						prev.append(group_pair[0][idx])
						idx+=1
					for prev_id in prev:
						result.append((prev_id, req_pair[1]))
		print("SPK edges found between:")
		# print(result)
		self.__spk_edges = result
		for i in result:
			print(i)
		for pair in result:
			self.__modified_DD.append((request_order[pair[0]], request_order[pair[1]]))

	def __sanity_check(self, ids, request_order):
		for id_pair in ids:
			index1 = request_order.index(id_pair[0])
			index2 = request_order.index(id_pair[1])
			assert index1 < index2, "ERROR: Find a reverse data dependency."

	def get_racing_request_groups(self):
		return self.__racing_request_groups

	def get_CD_groups(self):
		return self.__CD_groups

	def get_DD_groups(self):
		return self.__DD_groups

	def get_modified_DD(self):
		return self.__modified_DD

	def get_spk_edges(self):
		return self.__spk_edges
