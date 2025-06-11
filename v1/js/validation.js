$(document).ready(function() { //alert();
    // Generate a simple captcha
       $('#defaultForm').bootstrapValidator({ 
	// live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
			jobDone: {
                validators: {
                    notEmpty: {
                        message: 'Job Done Required'
                    }
                }
            },
			dgMake: {
                validators: {
                    notEmpty: {
                        message: 'DG Make Required'
                    }
                }
            },
			custDeliverAddr:{
                validators: {
                    notEmpty: {
                        message: 'Customer Address Required'
                    }
                }
            },
			role_name: {
                validators: {
                    notEmpty: {
                        message: 'Role Title Required'
                    }
                }
            },
			manufacturer: {
                validators: {
                    notEmpty: {
                        message: 'SMPS Manufacturer Required'
                    }
                }
            },
			fsraccept: {
                validators: {
                    notEmpty: {
                        message: 'Required'
                    }
                }
            },
			
			falset: {
                validators: {
                    notEmpty: {
                        message: 'Remarks Required'
                    }
                }
            },
			site_id: {
                validators: {
                    notEmpty: {
                        message: 'Site Id Required'
                    }
                }
            },
			siteName: {
                validators: {
                    notEmpty: {
                        message: 'Site Name Required'
                    }
                }
            },
			regions: {
                validators: {
                    notEmpty: {
                        message: 'Regions Required'
                    }
                }
            },
			zone: {
                validators: {
                    notEmpty: {message: 'Zone Required'}
                }
            },
			circle: {
                validators: {
                    notEmpty: {
                        message: 'Circle Required'
                    }
                }
            },
			cluster: {
                validators: {
                    notEmpty: {
                        message: 'Cluster Required'
                    }
                }
            },
			districts: {
                validators: {
                    notEmpty: {
                        message: 'District Required'
                    }
                }
            },
			'zone[]': {
                validators: {
                    notEmpty: {message: 'Zone Required'}
                }
            },
			'circle[]': {
                validators: {
                    notEmpty: {
                        message: 'Circle Required'
                    }
                }
            },
			'cluster[]': {
                validators: {
                    notEmpty: {
                        message: 'Cluster Required'
                    }
                }
            },
			'base_location': {
                validators: {
                    notEmpty: {
                        message: 'Base Location Required'
                    }
                }
            },
			description: {
                validators: {
                    notEmpty: {
                        message: 'description Required'
                    }
                }
            },
			category: {
                validators: {
                    notEmpty: {
                        message: 'Segment Required'
                    }
                }
            },
			customerName: {
                validators: {
                    notEmpty: {
                        message: ' Customer Name Required'
                    }
                }
            },
			customerCode: {
                validators: {
                    notEmpty: {
                        message: 'Customer Code Required'
                    }
                }
            },
			dispatch: {
                validators: {
                    notEmpty: {
                        message: 'Dispatch Months Required'
                    },
					integer: {
                        message: 'The value is not an integer'
                    }
                }
            },
			installation: {
                validators: {
                    notEmpty: {
                        message: 'installation Required'
                    },
					integer: {
                        message: 'The value is not an integer'
                    }
                }
            },
			categories: {
                validators: {
                    notEmpty: {
                        message: 'Product categories Required'
                    }
                }
            },
			schedule: {
                validators: {
                    notEmpty: {
                        message: 'Schedule Required'
                    }
                }
            },
			district: {
                validators: {
                    notEmpty: {
                        message: 'District Required'
                    }
                }
            },
			BatteryRating: {
                validators: {
                    notEmpty: {
                        message: 'BatteryRating Required'
                    }
                }
            },
			CellVoltage: {
                validators: {
                    notEmpty: {
                        message: 'CellVoltage Required'
                    },
					numeric: {
						separator:'.',
                        message: 'The value is not an integer'
                    }
                }
            },
			CellRating: {
                validators: {
                    notEmpty: {
                        message: 'CellRating Required'
                    },
					numeric: {
						separator:'.',
                        message: 'The value is not an integer'
                    }
                }
            },
			ProductCode: {
                validators: {
                    notEmpty: {
                        message: 'ProductCode Required'
                    }
                }
            },
			role: {
                validators: {
                    notEmpty: {
                        message: 'Emp Role Required'
                    }
                }
            },
			fault: {
                validators: {
                    notEmpty: {
                        message: 'Fault Code Required'
                    }
                }
            },
			employeeId: {
                validators: {
                    notEmpty: {
                        message: 'Employee Id Required'
                    }
                }
            },
			employeeName: {
                validators: {
                    notEmpty: {
                        message: 'Employee Name Required'
                    }
                }
            },
			employeeRole: {
                validators: {
                    notEmpty: {
                        message: 'Employee Role Required'
                    }
                }
            },
			base_location: {
                validators: {
                    notEmpty: {
                        message: 'Base Location Required'
                    }
                }
            },
			createdBy: {
                validators: {
                    notEmpty: {
                        message: 'Created By Required'
                    }
                }
            },
			complaint: {
                validators: {
                    notEmpty: {
                        message: 'Nature Complaint Required'
                    }
                }
            },
			code: {
                validators: {
                    notEmpty: {
                        message: 'Code Required'
                    }
                }
            },
			activity: {
                validators: {
                    notEmpty: {
                        message: 'Activity Required'
                    }
                }
            },
			displayName: {
                validators: {
                    notEmpty: {
                        message: 'Display Name Required'
                    }
                }
            },
			
			noofBanks: {
                validators: {
                    notEmpty: {
                        message: 'No.of Banks Required'
                    }
                }
            },
			sitePhotoGraphs: {
                validators: {
                    notEmpty: {
                        message: 'Site Photographs Required'
                    },
					file: {
						extension:'pdf',
						type: 'application/pdf',
						maxSize: 5050000,
                        message: 'Report PDF Only & Size <=5 MB'
						
                    }
                }
            },
			closedfsrreport: {
                validators: {
                    notEmpty: {
                        message: 'FSR Report Required'
                    },
                    file: {
						extension:'pdf',
						type: 'application/pdf',
						maxSize: 5050000,
                        message: 'Report PDF Only & Size <=5 MB'
						
                    }
                }
            },
			
			
			<!--start-->
			faultcode: {
				validators: {
					notEmpty: {
						message: 'Fault Code Required'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			physicaldamages: {
				validators: {
					notEmpty: {
						message: 'Physical Damages Required'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			smpscapacity: {
				validators: {
					notEmpty: {
						message: 'SMPS Capacity Required'
					}
				}
			},
			<!--end-->
			
						<!--start-->
			key:{
			selector:'.smpsdisplaycondition, .boostvoltage, .lvdsetting',
				validators: {
					notEmpty: {
						message: 'Required'
					}
				}
			},
			<!--end-->

			<!--start-->
			boostvoltage: {
				validators: {
					numeric: {
						separator:'.',
						message: 'The value is not an integer'
					}
				}
			},
			<!--end-->
			<!--start-->
			lvdsetting: {
				validators: {
					numeric: {
						separator:'.',
						message: 'The value is not an integer'
					}
				}
			},
			<!--end-->

			
			
			
			<!--start-->
			noofworkingmodules: {
				validators: {
					notEmpty: {
						message: 'Working Modules Required'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			permodulsrating: {
				validators: {
					notEmpty: {
						message: 'Per Moduls Rating Required'
					},
					numeric: {
						separator:'.',
						message: 'The value is not an integer'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			ebavailabilityperdayaspertechnician: {
				validators: {
					notEmpty: {
						message: 'EB Availability  Required'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			dgrunhoursperdayaspertechnician: {
				validators: {
					notEmpty: {
						message: 'DG Run Hours Required'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			logbookstatus: {
				validators: {
					notEmpty: {
						message: 'Log Book Status Required'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			dgcapacity: {
				validators: {
					notEmpty: {
						message: 'DG Capacity Required'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			dgstatus: {
				validators: {
					notEmpty: {
						message: 'DG Status Required'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			sitegauardavailability: {
				validators: {
					notEmpty: {
						message: 'Site Guard Required'
					} 
				}
			},
			<!--end-->
			
			<!--start-->
			acstatus: {
				validators: {
					notEmpty: {
						message: 'AC Status Required'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			sitetemperature: {
				validators: {
					notEmpty: {
						message: 'Site Temperature Required'
					},
					numeric: {
						separator:'.',
						message: 'The value is not an integer'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			floatvoltatterminal: {
				validators: {
					notEmpty: {
						message: 'Float Volt Required'
					},
					numeric: {
						separator:'.',
						message: 'The value is not an integer'
					}
				}
			},
			<!--end-->
			
			
			
			<!--start-->
			siteload: {
				validators: {
					notEmpty: {
						message: 'Site Load Required'
					},
					numeric: {
						separator:'.',
						message: 'The value is not an integer'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			lvdstatus: {
				validators: {
					notEmpty: {
						message: 'LVD Status Required'
					}
				}
			},
			<!--end-->
			
			
			
			<!--start-->
			nooffaultycells: {
				validators: {
					notEmpty: {
						message: 'No.of Faulty Cells Required'
					},
					integer: {
						message: 'The value is not an integer'
					}
				}
			},
			<!--end-->
			
			<!--start-->
			faultyCellSerial: {
				validators: {
					notEmpty: {
						message: 'Faulty Cell Serial Required'
					}
				}
			},
			<!--end-->
<!--start-->
			visitremark: {
				validators: {
					notEmpty: {
						message: 'Visite Remarks Required'
					},stringLength: {
                            min: 10,
                           // max: 100,
                            //message: 'The username must be more than 6 and less than 30 characters long'
                        }
				}
			},
			<!--end-->
			<!--start-->
			falset: {
				validators: {
					notEmpty: {
						message: 'Remarks Required'
					},stringLength: {
                            min: 10,
                           // max: 100,
                            //message: 'The username must be more than 6 and less than 30 characters long'
                        }
				}
			},
			<!--end-->
			<!--start-->
			completeobservation: {
				validators: {
					notEmpty: {
						message: 'Closing Remarks Required'
					},stringLength: {
                            min: 10,
                           // max: 100,
                            //message: 'The username must be more than 6 and less than 30 characters long'
                        }
				}
			},
			completeDesc: {
				validators: {
					notEmpty: {
						message: 'Complete Description Required'
					},stringLength: {
                            min: 10,
                           // max: 100,
                            //message: 'The username must be more than 6 and less than 30 characters long'
                        }
				}
			},
			<!--start-->
			commentsTE: {
				validators: {
					notEmpty: {
						message: 'Comment Required'
					},stringLength: {
                            min: 10,
                           // max: 100,
                            //message: 'The username must be more than 6 and less than 30 characters long'
                        }
				}
			},
			<!--end-->
			<!--start-->
			commentsSA: {
				validators: {
					notEmpty: {
						message: 'Comment Required'
					},stringLength: {
                            min: 10,
                           // max: 100,
                            //message: 'The username must be more than 6 and less than 30 characters long'
                        }
				}
			},
			<!--end-->
			fsrNumber: {
                validators: {
                    notEmpty: {
                        message: 'FSR Number Required'
                    },between: {
							min: 0000000000,
							max: 9999999999,
							message: 'FSR Number Should be Integer'
						}
                }
            },
			<!--start-->
			replacedCellSerial: {
                validators: {
                    notEmpty: {
                        message: 'Replaced Cell Serial Number Required'
                    },stringLength: {
                            min: 6,
							message: 'Enter minimum 6'
                        }
                }
            },
			<!--start-->
			visitfsrreport: {
				validators: {
                    notEmpty: {
                        message: 'FSR Report Required'
                    },
					file: {
						extension:'pdf',
						type: 'application/pdf',
						maxSize: 5050000,
                        message: 'Report PDF Only & Size <=5 MB'
						
                    }
                }
			},
			<!--end-->
			cDate: {
                validators: {
					 notEmpty: {
                        message: 'Closing Date Required'
                    }
                }
            },
		
			joiningDate: {
                validators: {
					 notEmpty: {
                        message: 'Joining Date Required'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'Its not in date format'
                    }
                }
            },
			visitedby: {
                validators: {
					 notEmpty: {
                        message: 'Visited Date Required'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'Its not in date format'
                    }
                }
            },
			/*mfdDate: {
                validators: {
					 date: {
                        format: 'YYYY-MM-DD',
                        message: 'Manufactured Date Required'
                    }
                }
            },
			installDate: {
                validators: {
					date: {
                        format: 'YYYY-MM-DD',
                        message: 'Installation Date Required'
                    }
                }
            },*/
			
			userEmail: {
                validators: {
                    notEmpty: {
                        message: 'The email address Required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
			email: {
                validators: {
                    notEmpty: {
                        message: 'The email address Required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
			
			password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and cannot be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },

			file1: {
                validators: {
                    notEmpty: {
						field: 'file',
                        message: 'File Required'
                    }
                }
            },
			role: {
                validators: {
                    notEmpty: {
                        message: 'User Role Required'
                    }
                }
            },
			
			ticketStatus: {
                validators: {
                    notEmpty: {
                        message: 'Ticket Status Required'
                    }
                }
            },
			numBanks: {
                validators: {
                    notEmpty: {
                        message: 'Number of Banks Required'
                    }
                }
            },CrName: {
                validators: {
                    notEmpty: {
                        message: 'Cr Name Required'
                    }
                }
            },
			CrNum: {
                validators: {
                    notEmpty: {
                        message: 'Cr Number Required'
                    }
                }
            },
			custCategory: {
                validators: {
                    notEmpty: {
                        message: 'Segment Required'
                    }
                }
            },
			siteType: {
                validators: {
                    notEmpty: {
                        message: 'Site Type Required'
                    }
                }
            },
			prodCode: {
                validators: {
                    notEmpty: {
                        message: 'Product Code Required'
                    }
                }
            },
			districts: {
                validators: {
                    notEmpty: {
                        message: 'Districts Required'
                    }
                }
            },
			natureOfComplaint: {
                validators: {
                    notEmpty: {
                        message: 'Nature Of Complaint Required'
                    }
                }
            },
			moc: {
                validators: {
                    notEmpty: {
                        message: 'MOC Required'
                    }
                }
            },
			completeDesc: {
                validators: {
                    notEmpty: {
                        message: 'Description Required'
                    }
                }
            },
			rating: {
                validators: {
                    notEmpty: {
                        message: 'Rating Required'
                    }
                }
            },
			natureOfActivity: {
                validators: {
                    notEmpty: {
                        message: 'Nature Of Activity Required'
                    }
                }
            },
			customerCategory: {
                validators: {
                    notEmpty: {
                        message: 'Segment Required'
                    }
                }
            },
			siteID: {
                validators: {
                    notEmpty: {
                        message: 'Site ID Required'
                    }
                }
            },
			siteAddress: {
                validators: {
                    notEmpty: {
                        message: 'Site Address Required'
                    }
                }
            },
			productCode: {
                validators: {
                    notEmpty: {
                        message: 'Product Code Required'
                    }
                }
            },
			noOfString: {
                validators: {
                    notEmpty: {
                        message: 'No Of String Required'
                    }
                }
            },
			clusterManagerName: {
                validators: {
                    notEmpty: {
                        message: 'Cluster Manager Name Required'
                    }
                }
            },
			contactNo: {
                validators: {
                    notEmpty: {
                        message: 'Contact Number Required'
                    },
					 between: {
                        min: 7000000000,
                        max: 9999999999,
                        message: 'Phone Number Should be 10 Numbers'
                    },
                }
            },
			customerNumber: {
               validators: {
					notEmpty: {
                        message: 'Customer Number Required'
                    },

                    between: {
                        min: 7000000000,
                        max: 9999999999,
                        message: 'Phone Number Should be 10 Numbers'
                    },
                }
            },
			contact: {
                validators: {
					notEmpty: {
                        message: 'Contact Number Required'
                    },

                    between: {
                        min: 7000000000,
                        max: 9999999999,
                        message: 'Phone Number Should be 10 Numbers'
                    },
                }
            },
			clusterManagerNumber: {
                validators: {
					notEmpty: {
                        message: 'Customer Manager Number Required'
                    },

                    between: {
                        min: 7000000000,
                        max: 9999999999,
                        message: 'Phone Number Should be 10 Numbers'
                    },
                }
            },
			siteStatus: {
                validators: {
                    notEmpty: {
                        message: 'siteStatus Required'
                    }
                }
            },
			clusterManagerMail: {
                validators: {
                    notEmpty: {
                        message: 'The email address Required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address',
						multiple:true,
						separator :','
                    }
                }
            },
			employeeID: {
                validators: {
                    notEmpty: {
                        message: 'Employee ID Required'
                    }
                }
            },
			circles: {
                validators: {
                    notEmpty: {
                        message: 'circles Required'
                    }
                }
            },
			clusters: {
                validators: {
                    notEmpty: {
                        message: 'clusters Required'
                    }
                }
            },
			circles: {
                validators: {
                    notEmpty: {
                        message: 'circles Required'
                    }
                }
            },
			
			designation: {
                validators: {
                    notEmpty: {
                        message: 'Designation Required'
                    }
                }
            },
			plannedDate: {
                validators: {
                    notEmpty: {
                        message: 'Planned Date Required'
                    }
                }
            },
			serviceEngineer: {
                validators: {
                    notEmpty: {
                        message: 'service Engineer Required'
                    }
                }
            },
			serviceEngineerMobile: {
                validators: {
					notEmpty: {
                        message: 'Service Engineer Number Required'
                    },

                    between: {
                        min: 7000000000,
                        max: 9999999999,
                        message: 'Phone Number Should be 10 Numbers'
                    },
                }
            },
			InputPassword1: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The username Required'
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            //message: 'The username must be more than 6 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\.]+$/,
                            //message: 'The username can only consist of alphabetical, number, dot and underscore'
                        }
                    }
                },
								mrfNumber: {
					validators: {
						notEmpty: {
							message: 'Material Request Form Required'
						}
					}
				},
				'zone[]': {
					validators: {
						notEmpty: {
							message: 'Zone Required'
						}
					}
				},
				'circle[]': {
					validators: {
						notEmpty: {
							message: 'Circle Required'
						}
					}
				},
				fromWh: {
					validators: {
						notEmpty: {
							message: 'from Wh Required'
						}
					}
				},
				toWh: {
					validators: {
						notEmpty: {
							message: 'to Wh Required'
						}
					}
				},
				mrfNumber: {
					validators: {
						notEmpty: {
							message: 'mrfNumber Required'
						}
					}
				},
				SJONumber: {
                validators: {
					notEmpty:{
						message:'SJO Number Required'
						}
					}
				},
				custName: {
					validators: {
						notEmpty: {
							message: 'Customer Name Required'
						}
					}
				},
				custNumber: {
					validators: {
						notEmpty: {
							message: 'Customer Number Required'
						},
						between: {
							min: 7000000000,
							max: 9999999999,
							message: 'Phone Number Should be 10 Numbers'
						},
						
					}
				},
				item: {
					validators: {
						notEmpty: {
							message: 'Item Name Required'
						}
					}
				},
				stockCategory: {
					validators: {
						notEmpty: {
							message: 'Stock Category Name Required'
						}
					}
				},
				'stockCategory[]': {
					validators: {
						notEmpty: {
							message: 'Stock Category Required'
						}
					}
				},
				invoiceNumber: {
					validators: {
						notEmpty: {
							message: 'Invoice Number Required'
						}
					}
				},
				invoiceDate: {
					validators: {
						notEmpty: {
							message: 'Invoice Date Required'
						},
                    	date: {
                        	format: 'YYYY-MM-DD',
                       	 	message: 'Its not in date format'
                   		}
					}
				},
				transporterDetails: {
					validators: {
						notEmpty: {
							message: 'Transporter Details Required'
						}
					}
				},
				docketNumber: {
					validators: {
						notEmpty: {
							message: 'Docket Number Required'
						}
					}
				},
				/*materialValue: {
                validators: {
					notEmpty:{
						message:'Material Value Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},*/
				pdf: {
					validators: {
						notEmpty: {
							message: 'pdf Required'
						},
						file: {
							extension:'pdf',
							type: 'application/pdf',
							maxSize: 5050000,
							message: 'Report PDF Only & Size <=5 MB'
							
						}
					}
				},
				'itemCode[]': {
					validators: {
						notEmpty: {
							message: 'Item Code Name Required'
						}
					}
				},
				'qty[]': {
                validators: {
					notEmpty:{
						message:'Quantity Value Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				qty: {
                validators: {
					notEmpty:{
						message:'Quantity Value Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				to: {
					validators: {
						notEmpty: {
							message: 'To Required'
						}
					}
				},
				mrfStatus: {
					validators: {
						notEmpty: {
							message: 'MRF Status Required'
						}
					}
				},
				
				'itemCode[]': {
					validators: {
						notEmpty: {
							message: 'Item Code Required'
						}
					}
				},
				itemDesc: {
					validators: {
						notEmpty: {
							message: 'Item Description Required'
						}
					}
				},
				price: {
					validators: {
						notEmpty: {
							message: 'Price Required'
						},
						numeric: {
							separator:'.',
							message: 'The value is not an integer'
						}
					}
				},
				whCode: {
					validators: {
						notEmpty: {
							message: 'Warehouse Code Required'
						}
					}
				},
				whDesc: {
					validators: {
						notEmpty: {
							message: 'Warehouse Description Required'
						}
					}
				},
				whAddress: {
					validators: {
						notEmpty: {
							message: 'Warehouse Address Required'
						}
					}
				},
				evCode: {
					validators: {
						notEmpty: {
							message: 'Emp / ESCA Code Required'
						}
					}
				},
				stockCode: {
					validators: {
						notEmpty: {
							message: 'Stock Code Required'
						}
					}
				},
				stockDesc: {
					validators: {
						notEmpty: {
							message: 'Stock Description Required'
						}
					}
				},
				noOfCells: {
                validators: {
					notEmpty:{
						message:'Number Of Cells Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				capacity: {
                validators: {
					notEmpty:{
						message:'Capacity Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				pdf: {
					validators: {
						notEmpty: {
							message: 'pdf Required'
						},
						file: {
							extension:'pdf',
							type: 'application/pdf',
							maxSize: 5050000,
							message: 'Report PDF Only & Size <=5 MB'
							
						}
					}
				},
				empId: {
					validators: {
						notEmpty: {
							message: 'Employee ID Required'
						}
					}
				},
				nameOfTheEmp: {
					validators: {
						notEmpty: {
							message: 'Employee Name Required'
						}
					}
				},
				stockCode: {
					validators: {
						notEmpty: {
							message: 'Stock Code Required'
						}
					}
				},
				visitFromDate : {
					validators: {
						notEmpty: {
							message: 'Visit From Date Required'
						}
					}
				},
				visitToDate: {
					validators: {
						notEmpty: {
							message: 'Visit to Date Required'
						}
					}
				},
				placesOfVisit: {
					validators: {
						notEmpty: {
							message: 'Places Of Visit Required'
						}
					}
				},
				purpose: {
					validators: {
						notEmpty: {
							message: 'Purpose Required'
						}
					}
				},
				nameOfEmployee: {
					validators: {
						notEmpty: {
							message: 'Name Of Employee Required'
						}
					}
				},
				advFor: {
					validators: {
						notEmpty: {
							message: 'Advance for Required'
						}
					}
				},
				reasonForAdv: {
					validators: {
						notEmpty: {
							message: 'reason For Advance Required'
						}
					}
				},
				escaName: {
					validators: {
						notEmpty: {
							message: 'ESCA Name Required'
						}
					}
				},
				period: {
                validators: {
					notEmpty:{
						message:'Period Required'
						}
					}
				},
				noOfDays: {
                validators: {
					notEmpty:{
						message:'No Of Days Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				totalTourexpenses: {
                validators: {
					notEmpty:{
						message:'Tourexpenses Required'
						}
					}
				},
				advRequested: {
                validators: {
					notEmpty:{
						message:'Advance Requested Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				advCleared: {
                validators: {
					notEmpty:{
						message:'Advance Cleared Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				amount: {
                validators: {
					notEmpty:{
						message:'Amount Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				circleDeductions: {
                validators: {
					notEmpty:{
						message:'Circle Deductions Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				corporateDeductions: {
                validators: {
					notEmpty:{
						message:'NHS Deductions Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				/*invNumber: {
                validators: {
					notEmpty:{
						message:'Invoice Number Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				invDate: {
                validators: {
					notEmpty:{
						message:'Invoice Date Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				ttNumber: {
                validators: {
					notEmpty:{
						message:'TT Number  Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},
				basicValue: {
                validators: {
					notEmpty:{
						message:'Basic Value  Required'
					},
                    integer: {
                        message: 'The value is not an integer'
                    	}
					}
				},*/

		}
	 });

    // Reset the Tooltip container form
    $('#resetButton').on('click', function(e) {
        var fields = $('#defaultForm').data('bootstrapValidator').getOptions().fields,
            $parent, $icon;

        for (var field in fields) {
            $parent = $('[name="' + field + '"]').parents('.form-group');
            $icon   = $parent.find('.form-control-feedback[data-bv-icon-for="' + field + '"]');
            $icon.tooltip('destroy');
        }

        // Then reset the form
        $('#defaultForm').data('bootstrapValidator').resetForm(true);
    });
});