import os
from entry import *
from ControlDependencyFinder import *

control_dependency_finder = ControlDependencyFinder(control_log_file)
req_list = control_dependency_finder.get_request_list()
# for req in req_list:
# 	print(req.get_url())
# 	print(req.get_request_id())

directory_in_str = "../../Replay/"
directory = os.fsencode(directory_in_str)

def bind_request():
	
	def get_gor_url(filename):
		filepath = directory_in_str + filename
		with open(filepath) as fp:
			for cnt, line in enumerate(fp):
				# print("Line {}: {}".format(cnt, line))
				if cnt == 1:
					return line.split()[1]

	request_idx_file_mapping = dict()
	file_idx = 0
	request_idx = 0
	for file in sorted(os.listdir(directory)):
		filename = os.fsdecode(file)
		if file_idx < 10:
			if filename == "xx0" + str(file_idx):
				if "load.php" in get_gor_url(filename):
					file_idx += 1
					continue
				# print(filename)
				# print(get_gor_url(filename))
				if get_gor_url(filename) == req_list[request_idx].get_url():
					request_idx_file_mapping[request_order.index(req_list[request_idx].get_request_id())] = directory_in_str + filename
					request_idx += 1
					file_idx += 1
				else:
					request_idx += 1
		else:
			if filename == "xx" + str(file_idx):
				if "load.php" in get_gor_url(filename):
					file_idx += 1
					continue
				# print(filename)
				# print(get_gor_url(filename))
				# print(get_gor_url(filename) == req_list[counter].get_url())
				# print(req_list[counter].get_url())
				# print(req_list[counter+1].get_url())
				if get_gor_url(filename) == req_list[request_idx].get_url():
					request_idx_file_mapping[request_order.index(req_list[request_idx].get_request_id())] = directory_in_str + filename
					request_idx += 1
					file_idx += 1
				else:
					request_idx += 1
	print(request_idx_file_mapping)
	print(len(request_idx_file_mapping))
	return request_idx_file_mapping
# bind_request()
