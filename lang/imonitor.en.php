<?php

const HEAD_LABEL_CONTRACT = "Monitoring Public Contracts";
const HEAD_PARAGRAPH_MONITUTOR = "Monitoring a public contract is another dimension of civic monitoring that allows you to help make sure that the funds allocated to your community are effectively reaching the people who should benefit from them. Public contracts are a key piece of how public resources are transformed into actual goods, services, or infrastructure that directly affect citizens’ lives. They define the conditions by which selected SUPPLIERS, i.e. companies hired to provide them, are to deliver those goods, services, or works when and where they are needed. <br />At the same time, public procurement is a part of the public administration that is vulnerable to inefficiencies and loss of resources through corruption and fraud, and this can happen in many different ways. For instance, ideally, suppliers are selected through competition to allow public agencies to award contracts under the most cost-beneficial conditions. However, often contracts are awarded in a way that lets someone unduly profit from them. This may be the case if the selection process is deliberately made less competitive to benefit a particular supplier, perhaps a company linked to public officials involved in the selection process. A supplier may also receive the contract at a higher cost than necessary or justifiable. In some cases, problems are observed when the contract is being implemented: the conditions established by the contract are not met by the supplier and those who should benefit from the contracted goods, services, or works receive them in lesser amounts or substandard quality, or in serious cases may not receive them at all.<br />Monithon now allows you to monitor this side of public policy implementation as well. Through the iMonitor initiative, you can access a series of training modules to help you understand basic aspects of public procurement and how it can be manipulated against the public interest. These will show you how to monitor selected contracts on the ground, collect evidence of whether a contract is being correctly implemented or not, and report the problems identified to the right authorities using this reporting tool. This can effectively help identify problems while they can still be remedied, making sure that goods, services, and works are being delivered effectively to citizens.The reporting template includes three parts, following a similar structure as the report for monitoring projects, where you will do your part:<br /><ul><li>Step 1 - Desk analysis</li><li>Step 2 - Contract implementation</li><li>Step 3 - Results and impact</li></ul>Each section has additional instructions on what information can be collected, where and how to collect them, as well as what is most relevant about them and what you should keep an eye out for. The questionnaire covers many aspects of monitoring a contract, but all questions are optional and responses can be edited before the report is submitted. The more information you collect, the better! You can find practical tips for writing your report in our iMonitor Manual: Monitoring Public Contracts.";
const HEAD_FIELD_OPENTENDER = "Enter URL of Contract from <a href=\"https://opentender.eu\" target='_blank'>OpenTender</a>";
const HEAD_BUTTON_IMPORTDATA = "Import data";
const HEAD_TEXT_OPENTENDER = "Contract url...";
const GENERIC_BUTTON_CALCULATE = "Calculate";
const GENERIC_RADIOLABEL_YES = "Yes";
const GENERIC_RADIOLABEL_NO = "No";
const GENERIC_RADIOLABEL_UNKNOWN = "I don't know";
const GENERIC_LABEL_DETAILEDINFO = "PLEASE INCLUDE MORE DETAILED INFORMATION IN THE FIELD BELOW.";
const GENERIC_HELP_DETAILEDINFO = "If your answer was “No”, describe the problems uncovered. Remain as factual and precise as you can.";
const NAV_TAB_1 = "Desk Analysis";
const NAV_TAB_2 = "Contract implementation";
const NAV_TAB_3 = "Results & Impact";
const S1_TITLE_LABEL = "Step 1 ";
const S1_TITLE_TEXT = "Desk Analysis";
const S1_PARAGRAPH_TEXT = "Monitoring the implementation of a contract involves essentially verifying whether what is defined on paper, i.e. in the contract, is taking place in reality, where the contract is being implemented. To assess this, some basic information from the contract itself and other related documents is important. Key documents may include:<br /><ul>contract;</li><li>contract extensions and modifications (if applicable);</li><li>contract implementation reports;</li><li>payment orders and invoices;</li><li>for construction projects, technical documents (e.g. blueprints, material specifications), and progress reports.</li></ul>Relevant background information on the awarding process may also be useful to gather information on how the supplier was selected. For this, an additional document that may be obtained is the bid evaluation report issued by the tender evaluation committee.<br />These may be accessed through online platforms with public procurement data, or requested by a public information request to the contracting agency or the responsible public procurement authority.<br />Other additional information may be useful too. For example, you can conduct a web search on key terms from the contract description (e.g. construction of a school in district XYZ) and the buyer (e.g. Municipality of XYZ) to find relevant background information on the contract or related project, which helps to understand more about the context of this particular contract and to what policy it is related. This can be reported in Section A: Project/Programme information. In this section, there is also an indication if the contract is linked to a project funded by the EU and where you can find information about it.<br />In Section B: Contract information, by inserting the link to the selected contract on the platform opentender.eu in the corresponding field, basic data on the contract will be automatically imported, including a contract integrity profile. You can edit that information or enter contract details from the contract obtained through the collected documentation or official data. These offer an overview of what the supplier is supposed to deliver, when and at what cost, and also some key conditions for the delivery, as well as whether there have been relevant modifications to those terms, which can sometimes indicate some type of manipulation.<br />Finally, if you want to dig a bit deeper you can also do some research on the supplier and add the information you find in Section C: Supplier information. These cover contact and registration information about the supplier, as well as other relevant information that you may find which could indicate additional corruption risks in how the contract was awarded. If there are subcontractors specified in the contract, you can also look up the same information on them and include them in the report.";
const S1_FIELD_TITLE = "Report title";
const S1_HELP_TITLE = "Report title...";
const S1_FIELD_AUTHOR = "Author of the report";
const S1_HELP_AUTHOR = "Include here the name of your organisation. If you don’t want that name to be disclosed, you may include “iMonitor team” instead";
const S1SA_LABEL_TEXT = "Section A: Project/Programme Information";
const S1SA_FIELD_EUFUNDED = "Is this contract related to an EU-funded project?";
const S1SA_FIELD_EUFUNDINFO = "PROJECT URL";
const S1SA_HELP_EUFUNDINFO = "If you have identified an EU-funded project to which this contract is linked, you can include the corresponding URL here. [FOR NATIONAL VERSIONS: In [Catalonia/Italy/Lithuania/Romania,] information on EU-funded projects can be found on this/these source(s):add link(s)]";
const S1SA_FIELD_PROJECTTITLE = "";
const S1SA_FIELD_FUNDINGAMOUNT = "TOTAL AMOUNT OF FUNDING RECEIVED BY THE PROJECT";
const S1SA_FIELD_MAINPOLICY = "MAIN POLICY AREA";
const S1SA_OPTION_MAINPOLICY_1 = "Transportation";
const S1SA_OPTION_MAINPOLICY_2 = "Environment";
const S1SA_OPTION_MAINPOLICY_3 = "Education";
const S1SA_OPTION_MAINPOLICY_4 = "Innovation";
const S1SA_FIELD_PROGRAMME = "POLICY PROGRAMME (FOR NATIONALLY FUNDED PROJECTS)";
const S1SA_HELP_PROGRAMME = "If you have identified a policy programme to which this contract is linked, you can mention it here. You may find information about this in the contract itself, through an online search on the object of the contract, or when you interview representatives from the contracting agency.";
const S1SB_LABEL_TEXT = "Section B: Contract information";
const S1SB_PARAGRAPH_TEXT = "This section imports several fields automatically from data available for this contract on opentender.eu. It also includes an integrity profile for each tender and contract, based on selected procurement corruption red flags. A lower integrity score is associated with a higher risk of procurement corruption.<br />If you have not selected the contract directly on opentender.eu, the information can be included by inserting the corresponding opentender.eu link at the top. You can complement it with information from other sources (e.g. national procurement portal, copy of contract). If you find a divergence of information between data from opentender.eu and the original contract, you can correct the information in the corresponding field. In that case, please make sure to attach the respective documentation to justify your corrections.";
const S1SB_FIELD_CONTRACTTITLE = "CONTRACT TITLE";
const S1SB_FIELD_CONTRACTOBJECT = "CONTRACT OBJECT";
const S1SB_HELP_CONTRACTOBJECT = "What is the exact product you are monitoring?";
const S1SB_FIELD_CONTRACTINGBODY = "CONTRACTING BODY";
const S1SB_HELP_CONTRACTINGBODY = "Which agency awarded the contract?";
const S1SB_FIELD_SUPPLIER = "Supplier";
const S1SB_HELP_SUPPLIER = "Who was awardaded the contract?";
const S1SB_FIELD_CONTRACTVALUE = "CONTRACT VALUE: WHAT IS THE TOTAL CONTRACT VALUE, AS ESTABLISHED IN THE ORIGINAL CONTRACT?";
const S1SB_HELP_CONTRACTVALUE = "If the final price imported from opentender.eu does not correspond to the contract value as specified in the contract, please include the original contract amount here.";
const S1SB_LABEL_CONTRACTINTEGRITY = "Contract Integrity Profile";
const S1SB_HELP_CONTRACTINTEGRITY = "";
const S1SB_FIELD_CONTRACTTYPE = "WHAT KIND OF CONTRACT ARE YOU MONITORING?";
const S1SB_HELP_CONTRACTTYPE = "This question refers to the primary category of the public contract you are monitoring. Public contracts can generally be classified into three main types: goods, works, and services.";
const S1SB_RADIOLABEL_CONTRACTTYPE_1 = "Goods";
const S1SB_RADIOLABEL_CONTRACTTYPE_2 = "Works";
const S1SB_RADIOLABEL_CONTRACTTYPE_3 = "Services";
const S1SB_RADIOLABEL_HELP_CONTRACTTYPE_1 = "CONTRACTS RELATED TO THE PURCHASE OF PHYSICAL ITEMS, SUCH AS OFFICE SUPPLIES, VEHICLES, OR MEDICAL EQUIPMENT. FOR EXAMPLE, IF YOUR CITY GOVERNMENT IS BUYING NEW OFFICE FURNITURE, IT FALLS UNDER THE \"GOODS\" CATEGORY.";
const S1SB_RADIOLABEL_HELP_CONTRACTTYPE_2 = "THESE CONTRACTS INVOLVE CONSTRUCTION OR INFRASTRUCTURE PROJECTS, INCLUDING ROADS, BRIDGES, PUBLIC BUILDINGS, AND UTILITIES. FOR INSTANCE, IF YOUR LOCAL GOVERNMENT IS BUILDING A NEW PARK OR RENOVATING A SCHOOL, THIS CONTRACT WOULD FALL UNDER THE \"WORKS\" CATEGORY.";
const S1SB_RADIOLABEL_HELP_CONTRACTTYPE_3 = "CONTRACTS FOR VARIOUS SERVICES, SUCH AS CONSULTING, MAINTENANCE, OR PROFESSIONAL EXPERTISE. AN EXAMPLE WOULD BE A CONTRACT WITH A CONSULTING FIRM TO CONDUCT AN ENVIRONMENTAL IMPACT ASSESSMENT.";
const S1SB_FIELD_SIGNATUREDATE = "SIGNATURE DATE";
const S1SB_HELP_SIGNATUREDATE = "When was the contract officially signed?";
const S1SB_FIELD_STARTDATE = "START DATE";
const S1SB_HELP_STARTDATE = "What is the start date of the contract period, as established in the original contract?";
const S1SB_FIELD_ENDDATE = "END DATE";
const S1SB_HELP_ENDDATE = "What is the end date of the contract period, as established in the original contract?";
const S1SB_FIELD_DELIVERYSITE = "IMPLEMENTATION/DELIVERY SITE";
const S1SB_HELP_DELIVERYSITE = "Where are the purchased goods/hired services/contracted works to be delivered?";
const S1SB_BUTTON_ADDDELIVERYSITE = "Add Another Delivery/Implementation site";
const S1SB_BUTTON_ADDMAPMARKERS = "Set map markers";
const S1SB_FIELD_DELIVERYSCHEDULE = "IMPLEMENTATION/DELIVERY SCHEDULE";
const S1SB_HELP_DELIVERYSCHEDULE = "When are the purchased goods/hired services to be delivered? / What is the planned date of completion for the contracted works?";
const S1SB_FIELD_SUPERVISOR = "CONTRACT SUPERVISOR";
const S1SB_HELP_SUPERVISOR = "What is the name of the person designated by the contracting agency to supervise the contract and its implementation?";
const S1SB_MODAL_SUPERVISOR = "The \"Contract supervisor\" is the person in charge of overseeing and ensuring the proper execution of the contract for the contracting agency. Their role is crucial in public procurementpublic contracting to guarantee that the contracted work or services meet the specified standards. The contract supervisor is responsible for:<ul><li>Monitoring Progress: They track the project's progress to ensure it stays on schedule and within budget.</li><li>Quality Assurance: They ensure that the delivered goods, works, or services meet the required quality and performance standards.</li><li>Compliance: The supervisor ensures that the contractor follows all specified terms and conditions in the contract, including legal and environmental regulations.</li></ul>Contract supervision is essential in public procurement/public contracting as it helps prevent issues such as cost overruns, delays, and substandard work. It also ensures transparency and accountability, as the supervisor acts as a watchdog on behalf of the public. For instance, if a city hires a construction company to build a new school, the contract supervisor ensures that the supplier meets contract conditions and completes the project on time while adhering to safety and quality standards.";
const S1SB_LABEL_SUBCONTRACTING = "SUBCONTRACTING ";
const S1SB_HELP_SUBCONTRACTING = "Does the contract designate other companies to provide part of the contracted services/works?";
const S1SB_MODAL_SUBCONTRACTING = "Subcontracting is when a contract assigns a portion of the work to another company or individual. It can be done for various reasons, like handling specialized tasks or achieving cost-effectiveness. For example, in a large infrastructure project, the main contractor might hire a specialised electrical company to handle electrical installations while concentrating on the primary construction work. This can save costs and improve project efficiency.<br />While subcontracting can be beneficial, it can also bring complexities and risks, including potential corruption. In some cases, a fake supplier (e.g. a shell company connected to a public official or politician) may be awarded the contract and then subcontract the work to the actual supplier while allowing part of the contract value to be diverted. Alternatively, the subcontractor may be a fake company used to divert payment for services that won't be provided.<br />Monitoring subcontracting is crucial to ensure that the subcontracted services are delivered and meet the standards specified in the main contract.";
const S1SB_RADIOLABEL_SUBCONTRACTING_1 = "";
const S1SB_RADIOLABEL_SUBCONTRACTING_2 = "";
const S1SB_RADIOLABEL_SUBCONTRACTING_3 = "";
const S1SB_LABEL_SUBCONTRACTORS = "WHO IS/ARE THE SUBCONTRACTOR(S)?";
const S1SB_FIELD_SUBCONTRACTORS_NAME = "Subcontractor's name...";
const S1SB_FIELD_SUBCONTRACTORS_VALUE = "Subcontract value...";
const S1SB_MODAL_SUBCONTRACTORS = "You can add here the name of the subcontractor(s) and the respective value of services/works to be supplied by them. In the case of multiple subcontractors, you can use the option “Add further subcontractor” below.";
const S1SB_BUTTON_ADDSUBCONTRACTORS = "Add Another Subcontractor";
const S1SB_LABEL_VALUESUBCONTRACTS = "TOTAL VALUE OF SUBCONTRACTED SERVICES";
const S1SB_HELP_VALUESUBCONTRACTS = "What is the total value of services/works to be provided by other companies, according to the contract?";
const S1SB_LABEL_PERCENTAGESUBCONTRACTS = "% OF SERVICES SUBCONTRACTED";
const S1SB_HELP_PERCENTAGESUBCONTRACTS = "What is the percentage of the total value of services/works to be provided by other companies, according to the contract?";
const S1SB_LABEL_CONTRACTMOD = "CONTRACT MODIFICATIONS";
const S1SB_HELP_CONTRACTMOD = "Has the contract been amended or extended?";
const S1SB_MODAL_CONTRACTMOD = "Contract modifications alter the contract's initial terms and conditions and can involve adjustments to project scope, budget, timelines, and other crucial elements. They must comply with the conditions for modifications established in the original contract, as well as with limits established in the applicable public procurement legislation (at the national and EU level). [In national versions, exclude the parenthesis and add: \"In [Catalonia/Italy/Lithuania/Romania], these are defined by Law N. xxx, in line with EU-level public procurement provisions, and define the following: [add bullet points with key limits for contract modifications]. The publication of a contract modification notice is also required.<br />These modifications are typically made to accommodate unexpected situations, changing project needs, or to correct errors or omissions in the original contract. They may, for instance, be used to extend the contract's duration beyond the initially set end date, due to reasons such as project delays, additional work requirements, or the need for extra time to complete the project, or also to adjust the contract value within legally defined limits.<br />Contract modifications can be vulnerable to corrupt practices if they lack transparency and proper oversight. They can be exploited to manipulate contract terms and inflate costs, resulting in the misappropriation of public funds. Therefore, it is important to closely monitor these aspects of a contract because they can significantly impact the use of public funds and the overall project's outcome, and it is essential to ensure that these changes are justified, within legal limits and in the public interest.";
const S1SB_LABEL_EXTENDEDDATE = "EXTENDED END DATE";
const S1SB_HELP_EXTENDEDDATE = "What is the new end date of the contract period, as defined in the last contract modification";
const S1SB_LABEL_DAYSEXTENDED = "DAYS EXTENDED";
const S1SB_HELP_DAYSEXTENDED = "By how many days is the initial contract period being extended in the contract modification(s)?";
const S1SB_LABEL_PERCENTINCREASEDURATION = "% INCREASE IN CONTRACT DURATION";
const S1SB_LABEL_NEWCONTRACTVALUE = "NEW CONTRACT VALUE";
const S1SB_HELP_NEWCONTRACTVALUE = "What is the new total contract value, as defined in the last contract modification?";
const S1SB_LABEL_NEWCONTRACTVALUEDIFF = "VALUE DIFFERENCE";
const S1SB_HELP_NEWCONTRACTVALUEDIFF = "By how much is the initial total contract value being increased in the contract modification?";
const S1SB_LABEL_PERCENTINCREASEVALUE = "% INCREASE IN CONTRACT VALUE";
const S1SC_LABEL_TEXT = "Section C: Supplier information";
const S1SC_LABEL_COMPANYINFO = "COMPANY INFORMATION";
const S1SC_LABEL_COMPANYNAME = "Name";
const S1SC_LABEL_COMPANYADDRESS = "Address";
const S1SC_LABEL_COMPANYPOSTALCODE = "Postal code";
const S1SC_LABEL_COMPANYCITY = "City";
const S1SC_LABEL_COMPANYNUTSCODE = "NUTS Code";
const S1SC_LABEL_COMPANYCOUNTRY = "Country";
const S1SC_LABEL_COMPANYCONTACTINFO = "Contact information";
const S1SC_LABEL_COMPANYPHONENUMBER = "Phone number";
const S1SC_LABEL_COMPANYEMAIL = "email";
const S1SC_LABEL_COMPANYWEBSITE = "website";
const S1SC_LABEL_COMPANYOTHER = "Other";
const S1SC_LABEL_COMPANYREGISTRATIONINFO = "Registration information";
const S1SC_LABEL_COMPANYREGISTRATIONID = "Company ID";
const S1SC_LABEL_COMPANYIDTYPE = "ID Type";
const S1SC_LABEL_COMPANYIDTYPE_1 = "VAT ID";
const S1SC_LABEL_COMPANYIDTYPE_2 = "Company Registry ID";
const S1SC_LABEL_COMPANYBUSINESSACTIVITYCODES = "Business Activity Codes";
const S1SC_LABEL_COMPANYFOUNDATION = "Foundation";
const S1SC_LABEL_COMPANYLEGALREP = "LEGAL REPRESENTIVE(S)";
const S1SC_LABEL_COMPANYSHAREHOLDERS = "SHAREHOLDER(S)";
const S1SC_LABEL_COMPANYOTHERINDIVIDUALS = "OTHER RELATED INDIVIDUAL(S)";
const S1SC_LABEL_COMPANYADDITIONALINFO = "ADDITIONAL RELEVANT INFORMATION";
const S2_TITLE_LABEL = "Contract Implementation";
const S2_TITLE_TEXT = "STEP 2 - CONTRACT IMPLEMENTATION";
const S2_PARAGRAPH_TEXT = "Now that you and your team have done your homework and collected the necessary background information and documentation, it is time to monitor actual contract implementation. In general, this is best done by visiting the contract implementation site, or selected sites, if there is more than one. There you can verify concretely whether the goods, services or works hired are being or were delivered according to contract conditions. You can consult the iMonitor Manual: Monitoring Public Contracts for practical guidance on how to plan and organise this part of the monitoring work, what to look for and how to document the evidence collected for reporting later. <br />Even if you are unable to inspect the implementation site, try to conduct the assessment based on the documentation obtained during the desk analysis. You can also gather information by interviewing relevant individuals, such as a representative of the contracting authority, in particular the designated contract supervisor, or a representative of the supplier. If you are monitoring a works contract and cannot access the site directly, you can try interviewing residents in the surrounding area.";
const S2SA_TITLE_TEXT = "Section A: Implementation";
const S2SA_LABEL_SITEINSPECTION = "SITE INSPECTION";
const S2SA_HELP_SITEINSPECTION = "Were you able to visit (any of) the implementation/delivery site(s) indicated in the contract?";
const S2SA_RADIOLABEL_SITEINSPECTION_1 = "";
const S2SA_RADIOLABEL_SITEINSPECTION_2 = "";
const S2SA_LABEL_SITEINSPECTED = "WHICH SITE HAS BEEN INSPECTED?";
const S2SA_HELP_SITEINSPECTED = "Here you can select the site from the ones indicated in the previous section. If you and your monitoring team visited more than one site, you can use the “Add another site” button below. Please include the date when you conducted the inspection.";
const S2SA_BUTTON_ADDINSPECTION = "Add Another Inspection";
const S2SA_BUTTON_UPDATESITELIST = "Update Inspection Site List";
const S2SA_LABEL_INSPECTIONFAIL = "YOU CAN INDICATE HERE ONE OR MORE REASONS WHY YOU/YOUR MONITORING TEAM WERE NOT ABLE TO VISIT AN IMPLEMENTATION SITE.";
const S2SA_OPTION_INSPECTIONFAIL_1 = "ACCESS TO THE SITE WAS DENIED";
const S2SA_OPTION_INSPECTIONFAIL_2 = "THE SITE COULD NOT BE PRECISELY LOCATED";
const S2SA_OPTION_INSPECTIONFAIL_3 = "INSUFFICIENT RESOURCES";
const S2SA_LABEL_IMPLEMENTATIONSTATUS = "WHAT IS THE IMPLEMENTATION STATUS OF THE PROJECT?";
const S2SA_RADIOLABEL_IMPLEMENTATIONSTATUS_1 = "Not started";
const S2SA_RADIOLABEL_IMPLEMENTATIONSTATUS_2 = "Ongoing";
const S2SA_RADIOLABEL_IMPLEMENTATIONSTATUS_3 = "Finished";
const S2SA_HELP_IMPLEMENTATIONSTATUS_1 = "THE CONTRACT IS IN FORCE BUT ACTUAL IMPLEMENTATION HAS NOT BEGUN ACCORDING TO THE IMPLEMENTATION SCHEDULE.";
const S2SA_HELP_IMPLEMENTATIONSTATUS_2 = "IMPLEMENTATION HAS ALREADY BEGUN.";
const S2SA_HELP_IMPLEMENTATIONSTATUS_3 = "IMPLEMENTATION REPORTED AS COMPLETED AND THE CONTRACT HAS ENDED.";
const S2SA_LABEL_IMPLEMENTATIONSTATUSINFO = "IF YOU HAVE INFORMATION ON WHY IMPLEMENTATION HAS NOT STARTED AS PLANNED, YOU CAN INCLUDE THEM HERE.";
const S2SA_LABEL_IMPLEMENTATIONSCHEDULE = "IS CONTRACT IMPLEMENTATION FOLLOWING THE ESTABLISHED SCHEDULE?";
const S2SA_MODAL_IMPLEMENTATIONSCHEDULE = "Consider whether the delivery of goods/services/works has started according to the agreed schedule and if implementation is progressing without significant delays. This data can be obtained from contract implementation reports, on-site observations, or interviews with individuals overseeing the implementation process. If there have been delays, try to gather and report information on what has caused them.";
const S2SA_LABEL_CONTRACTMODSINWRITING = "IS CONTRACT IMPLEMENTATION FOLLOWING THE ESTABLISHED SCHEDULE?";
const S2SA_MODAL_CONTRACTMODSINWRITING = "Contract modifications usually require written justification as to why they are needed for the continuation and conclusion of the contract. You can check if the obtained documentation includes detailed justifications for any existing contract modification.<br />If you are monitoring a works contract, you can also assess whether contract modifications are justified from a technical perspective. For example, you can assess whether the changes involve services that were clearly needed and should have been part of the initial tender, or conversely, if they include services that are unnecessary or not cost-effective from a technical perspective. In cases where there are cost modifications, you can also consider whether the pricing of the included services aligns with market standards.";
const S2SA_LABEL_CONTRACTPROVISIONSFULFILLED = "ARE OTHER CONTRACT PROVISIONS BEING FULFILLED?";
const S2SA_MODAL_CONTRACTPROVISIONSFULFILLED = "Public contracts have other specific provisions for proper implementation. Here are some relevant points to check while monitoring them:<br /><ul><li>Are goods/services/works being provided only by the supplier and subcontractors specified in the contract? This can be verified by examining documentation, identifying equipment on the site, checking workers' uniforms, and interviewing individuals at the site and nearby residents. If there is evidence of informal or additional subcontracting, please provide a description and mention which other companies seem to be involved in the contract's execution.</li><li>Is the contract being supervised by the assigned contract supervisor from the contracting agency? You can check if implementation documents (such as payment orders and progress reports) are signed by them or by asking people at the site if they regularly visit.</li><li>If the supplier violated any contract provisions, have any penalties been imposed according to the contract terms? You can review the implementation documents to see if there are records of written notices or fines applied.</li></ul>";
const S2SA_LABEL_SUPPLIERDELIVER = "DID THE SUPPLIER FULLY DELIVER THE AGREED GOODS/SERVICES/WORKS AS SPECIFIED IN THE CONTRACT?";
const S2SA_MODAL_SUPPLIERDELIVER = "Here, you can report whether the implementation as observed at the site matches completion certificates or if it's incomplete. If you are monitoring a works contract, check if the contracting agency conducted a proper inspection of the completed project. You can also talk to recipients or beneficiaries of goods or services and find out if they have any complaints about partial delivery.";
const S2SA_LABEL_DELIVEREDGOODS = "Did the delivered goods/works remain in an acceptable state following contract completion?";
const S2SA_MODAL_DELIVEREDGOODS = "If the implementation of your selected contract was complete at the time of monitoring, you can also observe the conditions in which the goods and works delivered were found when you visited the site. Some observable issues (e.g. loosening paint, wall cracks, poorly installed equipment) only a few months after completion could point to inadequate contract implementation and are worth reporting.";
const S2SA_LABEL_PROCUREDGOODS = "Are the procured goods being used for the intended purpose and by the intended beneficiaries?";
const S2SA_LABEL_WORKSCONTRACT = "In the case of a works contract, is the project complete and fully operational?";
const S2SA_LABEL_ADDITIONALINFO = "Additional relevant information";
const S2SB_TITLE_TEXT = "Investigation methods";
const S2SB_LABEL_SOURCES = "Sources";
const S2SB_LABEL_SOURCES_WEB = "Web research";
const S2SB_LABEL_SOURCES_DOCS = "Request for documentation";
const S2SB_LABEL_SOURCES_SITE = "Site inspection";
const S2SB_LABEL_SOURCES_INTERVIEW_REPS = "Interview/meeting with representatives of the contracting authority";
const S2SB_LABEL_SOURCES_INTERVIEW_SUPERVISOR = "Interview/meeting with contract supervisor";
const S2SB_LABEL_SOURCES_INTERVIEW_RCI = "Interview/meeting with people responsible for contract implementation";
const S2SB_LABEL_SOURCES_BENEFICIARIES = "Interview/meeting with final beneficiaries of contracted goods/services/works";
const S2SB_LABEL_SOURCES_OTHER = "Interview/meeting with other types of people (e.g. nearby residents)";
const S2SB_LABEL_DOCUMENTATIONACCESS = "HAVE YOU BEEN ABLE TO ACCESS ALL THE KEY DOCUMENTATION FOR THE MONITORING?";
const S2SB_OPTION_DOCUMENTATIONACCESS_1 = "CONTRACT";
const S2SB_OPTION_DOCUMENTATIONACCESS_2 = "CONTRACT EXTENSIONS AND MODIFICATIONS (IF APPLICABLE)";
const S2SB_OPTION_DOCUMENTATIONACCESS_3 = "CONTRACT IMPLEMENTATION REPORTS";
const S2SB_OPTION_DOCUMENTATIONACCESS_4 = "PAYMENT ORDERS AND INVOICES";
const S2SB_OPTION_DOCUMENTATIONACCESS_5 = "FOR CONSTRUCTION PROJECTS: TECHNICAL DOCUMENTS (E.G. BLUEPRINTS, MATERIAL SPECIFICATIONS) AND PROGRESS REPORTS";
const S2SB_OPTION_DOCUMENTATIONACCESS_6 = "BID EVALUATION REPORT";
const S2SB_LABEL_DOCUMENTATIONACCESSFAIL = "IF YOU COULD NOT ACCESS ALL DOCUMENTATION, PLEASE INDICATE THE OBSTACLES FACED. YOU CAN ADD ADDITIONAL COMMENTS BELOW.";
const S2SB_OPTION_DOCUMENTATIONACCESSFAIL_1 = "DOCUMENTATION WAS INCOMPLETE";
const S2SB_OPTION_DOCUMENTATIONACCESSFAIL_2 = "DOCUMENTATION WAS NOT OBTAINED IN TIME";
const S2SB_OPTION_DOCUMENTATIONACCESSFAIL_3 = "REQUEST FOR ACCESS WAS NOT GRANTED";
const S2SB_LABEL_INTERVIEWS = "WHO DID YOU INTERVIEW?";
const S2SB_HELP_INTERVIEWS = "You can list here their names and roles.";
const S2SB_TEXT_INTERVIEWNAME = "Name...";
const S2SB_TEXT_INTERVIEWROLE = "Role...";
const S2SB_BUTTON_ADDINTERVIEW = "Add Another Interview";
const S2SB_LABEL_ONLINESOURCES = "WHAT ONLINE SOURCES DID YOU USE?";
const S3_TITLE_LABEL = "STEP 3";
const S3_TITLE_TEXT = "Results & Impact";
const S3S_TITLE_CONNECTIONS = "New Connections that you generated";
const S3S_LABEL_CONNECTIONS = "How did you disseminate or are you disseminating the results of your civic monitoring?";
const S3S_OPTION_CONNECTIONS_1 = "X/Twitter";
const S3S_OPTION_CONNECTIONS_2 = "Facebook";
const S3S_OPTION_CONNECTIONS_3 = "Instagram";
const S3S_OPTION_CONNECTIONS_4 = "Local events";
const S3S_OPTION_CONNECTIONS_5 = "Team/Organisation blog/website";
const S3S_OPTION_CONNECTIONS_6 = "Flyers or other offline methods (non-Internet)";
const S3S_OPTION_CONNECTIONS_7 = "Requests for private hearings or meetings";
const S3S_OPTION_CONNECTIONS_8 = "Media Interviews";
const S3S_LABEL_CONNECTION_PERSON = "With whom have you created connections for discussing the results of your monitoring?";
const S3S_LABEL_CONNECTION_PERSON_NAME = "Person";
const S3S_LABEL_CONNECTION_PERSON_ROLE = "Role";
const S3S_LABEL_CONNECTION_PERSON_ORG = "Organisation";
const S3S_LABEL_CONNECTION_PERSON_TYPE = "Connection type";
const S3S_BUTTON_ADDCONNECTION = "Add Subject";
const S3S_LABEL_MEDIA = "has the media talked about your monitoring?";
const S3S_LABEL_WHICHMEDIA = "If yes, the monitoring results have been shot by this media:";
const S3S_OPTION_WHICHMEDIA_1 = "Local TV";
const S3S_OPTION_WHICHMEDIA_2 = "National TV";
const S3S_OPTION_WHICHMEDIA_3 = "Local newspapers";
const S3S_OPTION_WHICHMEDIA_4 = "National newspapers";
const S3S_OPTION_WHICHMEDIA_5 = "Blog or other online news outlet";
const S3S_LABEL_CONTACTWITHADMINISTRATION = "Did you have contacts with public administrations (Mayor or executive personnel) to show or discuss with them your monitoring results?";
const S3S_LABEL_ADMINISTRATIONQUESTIONS = "Have the public administrations responded to your requests or problems raised?";
const S3S_OPTION_ADMINISTRATIONQUESTIONS_1 = "No response";
const S3S_OPTION_ADMINISTRATIONQUESTIONS_2 = "Some have responded, others not";
const S3S_OPTION_ADMINISTRATIONQUESTIONS_3 = "They gave us formal or generic responses";
const S3S_OPTION_ADMINISTRATIONQUESTIONS_4 = "At least one of those contacted gave us concrete feedback";
const S3S_OPTION_ADMINISTRATIONQUESTIONS_5 = "They put our recommendations into practice and the project is now in progress or more effective";
const S3S_OPTION_ADMINISTRATIONQUESTIONS_6 = "We reported a problem that has now been resolved";
const S3S_LABEL_CASEDESCRIPTION = "Describe your case. Which material facts or events lead you to believe that your civic monitoring had (or did not have) an impact on the organisations involved in the contract you monitored?";
const GENERIC_LABEL_OTHER = "Other:";
const GENERIC_LABEL_FILEUPLOAD = "FIle Upload (e.g. pictures, videos, pdf...)";
const GENERIC_HELP_FILEUPLOAD = "Upload here what you were able to collect on-site. If you like, you can add a brief note about that file and what it documents. If you have more than one file, use the “Add another file” button below.";
const GENERIC_FIELD_FILENAME = "File name";
const GENERIC_FIELD_FILEDESCRIPTION = "File description";
const GENERIC_BUTTON_ADDFILEUPLOAD = "Add another file";
const INTEGRITY_LABEL_PROCEDURE = "Procedure";
const INTEGRITY_LABEL_SINGLE_BID = "Single Bid";
const INTEGRITY_LABEL_TAX_HAVEN = "Tax Haven";
const INTEGRITY_LABEL_ADVERTISEMENT_PERIOD = "Advertisement period";
const INTEGRITY_LABEL_CALL_FOR_TENDER_PUBLICATION = "Call for tender publication";
const INTEGRITY_LABEL_NEW_COMPANY = "New Company";
const INTEGRITY_LABEL_DECISION_PERIOD = "Decision period";
const INTEGRITY_LABEL_INDICATOR = "Indicator";
const INTEGRITY_LABEL_SCORE = "Score";
const INTEGRITY_LABEL_RAW_VALUE = "Raw value";

