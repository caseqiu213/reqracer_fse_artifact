from DependencyGraphBuilder import *
from AccessCheckerQuery import *
from structures.basics.FileReaderV2 import *
from structures.SchemaParser import *
from structures.basics.MyDict import *
from structures.InstructionV2 import *
from structures.RequestWithInstrs import *
from structures.moodle_schema_parser import *
from SerializabilityChecks import *
# from InterleavingGenerator import *
from AccessCheckerQueryDup import *
import copy

bug = int(input ("Enter bug number: "))

'''
declare log file path
'''

if bug == 11073:
    log_file = "../logs/11073.log"
    control_log_file = "../logs/11073_token.log"
if bug == 11437:
    log_file = "../logs/11437.log"
    control_log_file = "../logs/11437_token.log"
if bug == 24933:
    log_file = "../logs/24933.log"
    control_log_file = "../logs/24933_token.log"
if bug == 40594:
    log_file = "../logs/40594.log"
    control_log_file = "../logs/40594_token.log"
if bug == 69815:
    log_file = "../logs/69815.log"
    control_log_file = "../logs/69815_token.log"
if bug == 28949:
    log_file = "../logs/28949.log"
    control_log_file = "../logs/28949_token.log"
if bug == 43421:
    log_file = "../logs/43421.log"
    control_log_file = "../logs/43421_token.log"
if bug == 51707:
    log_file = "../logs/51707.log"
    control_log_file = "../logs/51707_token.log"
if bug == 59854:
    log_file = "../logs/59854.log"
    control_log_file = "../logs/59854_token.log"
if bug == 1484216:
    log_file = "../logs/1484216.log"
    control_log_file = "../logs/1484216_token.log"

wp_path = "../schema_files/wordpress_schema.txt"
mw_path = "../schema_files/mediawiki_schema.txt"
mdl_path = "../schema_files/moodle_schema.txt"
'''
The following part read the schema and query log

'''

fr = FileReader(log_file)
fr.parse()
content = fr.get_content()
if bug == 11073 or bug == 11437 or bug == 24933:
    schema = SchemaParser(wp_path)
if bug == 40594 or bug == 69815:
    schema = SchemaParser(mw_path)
if bug == 28949 or bug == 43421 or bug == 51707 or bug == 59854 or bug == 1484216:
    schema = moodle_schema_parser(mdl_path)

db_dict = schema.get_db_dict()
auto_dict = schema.get_autoinc_dict()
# print(db_dict)
# print(auto_dict)

''' instr_set will be used to find conflicting accesses
 and data dependency
request dict is request_id: number of queries
'''
instr_set = []
request_dict = RequestDict()
request_order = []

for line in content:
    instruction = Instruction(line, db_dict)
    request_key = instruction.get_request_id()
    if request_key != '':
        if request_key not in request_dict:
            request_order.append(request_key)
            request_dict.add(request_key, 1)
            instruction.set_query_id(1)
        else:
            request_dict.update_value(request_key)
            value = request_dict[request_key]
            instruction.set_query_id(value)
    instr_set.append(instruction)

print("Number of requests:")
print(len(request_order))
# print(request_order)

# print("Request(s) need to be duplicated:")
request_query_list = []
for key in request_dict:
    request_query = RequestWithInstrs(instr_set, key)
    request_query_list.append(request_query)

dup_request_list = []
for request in request_query_list:
    if request.get_duplicate_need():
        dup = copy.deepcopy(request)
        dup.set_request_id()
        if dup not in dup_request_list:
            dup_request_list.append(dup)

for i in dup_request_list:
    myid = i.get_request_id()
# print(myid[:-1])

dup_instr_set = []
for i in dup_request_list:
    myid = i.get_request_id()
    # print(myid)
    '''
    change the request id of instructions in the duplicate request
    '''
    for instr in i.get_instrs():
        instr.set_request_id(myid)
        dup_instr_set.append(instr)


def serializability_check(racing_request_pairs, request_order, bug, dup=None, flag=0):
    print("Start Serializability check:")
    results = []
    file_num = 0
    for pair in racing_request_pairs:
        req1 = pair.get_racing_request_id_pair()[0]
        req2 = pair.get_racing_request_id_pair()[1]
        instrs = pair.get_racing_instrs()

        req1_instr_list = []
        req2_instr_list = []

        # for instr_pair in instrs:
        # 	if instr_pair[0].get_request_id() == req1:
        # 		req1_instr_list.append(instr_pair[0])
        # 	if instr_pair[1].get_request_id() == req1:
        # 		req1_instr_list.append(instr_pair[1])
        # 	if instr_pair[0].get_request_id() == req2:
        # 		req1_instr_list.append(instr_pair[0])
        # 	if instr_pair[1].get_request_id() == req2:
        # 		req1_instr_list.append(instr_pair[1])
        for i in instr_set:
            if i.get_request_id() == req1:
                req1_instr_list.append(i)
            if i.get_request_id() == req2:
                req2_instr_list.append(i)
        if dup:
            for i in dup:
                if i.get_request_id() == req1:
                    req1_instr_list.append(i)
                if i.get_request_id() == req2:
                    req2_instr_list.append(i)

        if type1_check(req1, req2, request_order, bug, file_num, req1_instr_list, req2_instr_list, instrs, flag):
            file_num += 1
            if [req1, req2] not in results and [req2, req1] not in results:
                results.append([req1, req2])
                continue
            # print("pass type1 check:")
            # print([req1, req2])

        if type2_check(req1, req2, request_order, bug, file_num, req1_instr_list, req2_instr_list, instrs, flag):
            file_num += 1
            if [req1, req2] not in results and [req2, req1] not in results:
                results.append([req1, req2])
                continue
            # print("pass type2 check:")
            # print([req1, req2])

        if type3_check(req1, req2, request_order, bug, file_num, req1_instr_list, req2_instr_list, instrs, flag):
            file_num += 1
            if [req1, req2] not in results and [req2, req1] not in results:
                results.append([req1, req2])
                continue
            # print("pass type3 check:")
            # print([req1, req2])

        if type4_check(req1, req2, request_order, bug, file_num, req1_instr_list, req2_instr_list, instrs, flag):
            file_num += 1
            if [req1, req2] not in results and [req2, req1] not in results:
                results.append([req1, req2])
                continue
            # print("pass type4 check:")
            # print([req1, req2])

    print("Number of request pairs after serializability check:")
    print(len(results))
    print("===================================================")
    for i in results:
        print(i)
        if i[0] not in request_order:
            print(sorted([request_order.index(i[0][:-1]), request_order.index(i[1])]))
        if i[1] not in request_order:
            print(sorted([request_order.index(i[0]), request_order.index(i[1][:-1])]))
        if i[0] in request_order and i[1] in request_order:
            print(sorted([request_order.index(i[0]), request_order.index(i[1])]))
    return results

'''
Check conflict access in duplicated requests
'''
ACDup = AccessCheckerQueryDup(dup_request_list, request_query_list, db_dict)
racing_dup = ACDup.get_racing_request_pairs()
print("The number of racing request pairs when duplicate: ")
print(len(racing_dup))
racing_request_pairs_dup = serializability_check(racing_dup, request_order, bug, dup_instr_set, 1)

'''
Check conflict access
'''
AC = AccessCheckerQuery(request_query_list, db_dict)
racing_request_pairs = AC.get_racing_request_pairs()
print("\n\n")
print("The number of racing request pairs: ")
# print(len(racing_request_pairs))
count = 0
request_prune = []
prune = []
for pair1 in racing_request_pairs:
    # print(pair1.get_racing_request_id_pair())
    for pair2 in racing_request_pairs:
        ids1 = pair1.get_racing_request_id_pair()
        ids2 = pair2.get_racing_request_id_pair()
        if ids1[0] == ids2[1] and ids1[1] == ids2[0]:
            if pair1.get_racing_instrs() == pair2.get_racing_instrs():
                if ids1 not in request_prune and ids2 not in request_prune:
                    request_prune.append(ids1)
                    prune.append(pair1)
# print("duplicate")
# print(len(prune))
racing_request_pairs = [x for x in racing_request_pairs if x not in prune]
print(len(racing_request_pairs))

'''
Build dependency graph in requests
'''
if control_log_file:
    DGBuilder = DependencyGraphBuilder(control_log_file, instr_set, auto_dict, request_order)

    CD_groups = DGBuilder.get_CD_groups()
    CD_request_idx=[]
    print("===================================================")
    print("RRR Dependency:")
    for i in CD_groups:
        res = []
        for j in i:
            if j in request_order:
                res.append(request_order.index(j))
        if res:
            res=sorted(res)
            CD_request_idx.append(res)
    CD_request_idx.sort(key=lambda x: x[0])
    print("Group requests by RRR Dependency")
    # print(CD_request_idx)
    for i in CD_request_idx:
        print(i)

    CD_prune = []
    for request_pair in racing_request_pairs:
        for group in CD_groups:
            if (request_pair.get_racing_request_id_pair()[0] in group and request_pair.get_racing_request_id_pair()[
                1] in group):
                if request_pair not in CD_prune:
                    CD_prune.append(request_pair)
    print("Number of racing request pairs pruned by checking RRR Dependency")
    print(len(CD_prune))

    racing_request_pairs = [x for x in racing_request_pairs if x not in CD_prune]
    # print(len(racing_request_pairs))

    # DD_groups = DGBuilder.get_DD_groups()
    # print("===================================================")
    # print("Data Dependency:")
    # for i in DD_groups:
    #     res_dd = []
    #     for cd in i:
    #         res = []
    #         for j in cd:
    #             if j not in request_order:
    #                 continue
    #             res.append(request_order.index(j))
    #         res_dd.append(sorted(res))
    #     print(res_dd)
    # # print("Number of DD groups: ")
    # # print(len(DD_groups))
    # # DD_prune = []
    # # for request_pair in racing_request_pairs:
    # #     for group in DD_groups:
    # #         if (request_pair.get_racing_request_id_pair()[0] in group[0] and request_pair.get_racing_request_id_pair()[
    # #             1] in group[1]):
    # #             if request_pair not in DD_prune:
    # #                 DD_prune.append(request_pair)
    # #         if (request_pair.get_racing_request_id_pair()[1] in group[0] and request_pair.get_racing_request_id_pair()[
    # #             1] in group[0]):
    # #             if request_pair not in DD_prune:
    # #                 DD_prune.append(request_pair)
    # # print("Number of racing request pairs pruned by checking Data Dependency")
    # # print(len(DD_prune))
    # 2021 Feb new implementation
    modified_DD_prune=[]
    modified_DD_pairs=DGBuilder.get_modified_DD()
    for request_pair in racing_request_pairs:
        for pair in modified_DD_pairs:
            if request_pair.get_racing_request_id_pair()[0] in pair and request_pair.get_racing_request_id_pair()[1] in pair:
                if(request_pair not in modified_DD_prune):
                    modified_DD_prune.append(request_pair)
    racing_request_pairs = [x for x in racing_request_pairs if x not in modified_DD_prune]
    # print("Number of racing request pairs pruned by checking Data Dependency")
    # print(len(modified_DD_prune))

    # # racing_request_pairs = [x for x in racing_request_pairs if x not in DD_prune]
    # print("Number of request pairs before serializability check:")
    # print(len(racing_request_pairs))

    requests_with_instr = racing_request_pairs
    racing_request_pairs=serializability_check(racing_request_pairs, request_order, bug)

    # modified_DD_prune=[]
    # modified_DD_pairs=DGBuilder.get_modified_DD()
    # for request_pair in racing_request_pairs:
    #     for pair in modified_DD_pairs:
    #         if request_pair[0] in pair and request_pair[1] in pair:
    #             if(request_pair not in modified_DD_prune):
    #                 modified_DD_prune.append(request_pair)
    # racing_request_pairs = [x for x in racing_request_pairs if x not in modified_DD_prune]
    # print(len(racing_request_pairs))

# Search the target query
# for instr in instr_set:
    # if "INSERT INTO `wp_comments" in instr.get_query():
    #     print(f"Request id: {request_order.index(instr.get_request_id())+1}")
    #     print(f"Query id: {instr.get_query_id()+1}")
    #     print(f"Query: {instr.get_query()}")
        
    # if "post-trashed" in instr.get_query():
    #     print(f"Request id: {request_order.index(instr.get_request_id())+1}")
    #     print(f"Query id: {instr.get_query_id()+1}")
    #     print(f"Query: {instr.get_query()}")

    # if request_order.index(instr.get_request_id()) == 18 and "wp_comments" in instr.get_query():
    #     print("================================")
    #     print(f"Request id: {request_order.index(instr.get_request_id())+1}")
    #     print(f"Query id: {instr.get_query_id()}")
    #     print(f"Query: {instr.get_query()}")
    
    # if request_order.index(instr.get_request_id()) == 22 and "wp_comments" in instr.get_query():
    #     print("================================")
    #     print(f"Request id: {request_order.index(instr.get_request_id())+1}")
    #     print(f"Query id: {instr.get_query_id()}")
    #     print(f"Query: {instr.get_query()}")
    def get_rrr_groups():
        return CD_request_idx

    def get_spk_edges():
        return DGBuilder.get_spk_edges()

    def get_racing_request_pairs():
        return racing_request_pairs, request_order

    def get_racing_request_pairs_dup():
        return racing_request_pairs_dup, request_order

    def get_requests_with_instr():
        return request_query_list, request_order
