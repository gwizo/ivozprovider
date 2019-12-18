Feature: Retrieve billable calls

  @createSchema
  Scenario: Retrieve billable call json list
    Given I add Authorization header
     When I add "Accept" header equal to "application/json"
      And I send a "GET" request to "billable_calls?_itemsPerPage=2"
     Then the response status code should be 200
      And the response should be in JSON
      And the header "Content-Type" should be equal to "application/json; charset=utf-8"
      And the JSON should be equal to:
    """
      [
          {
              "callid": "017cc7c8-eb38-4bbd-9318-524a274f7000",
              "startTime": "2019-01-01 09:00:00",
              "duration": 0,
              "caller": "+34633646464",
              "callee": "+34633656565",
              "cost": null,
              "price": 1,
              "endpointType": null,
              "endpointId": null,
              "direction": "outbound",
              "id": 1,
              "brand": 1,
              "company": 1,
              "invoice": 1
          },
          {
              "callid": "017cc7c8-eb38-4bbd-9318-524a274f7001",
              "startTime": "2019-01-01 09:00:01",
              "duration": 0,
              "caller": "+34633646464",
              "callee": "+34633656565",
              "cost": null,
              "price": 1,
              "endpointType": null,
              "endpointId": null,
              "direction": "outbound",
              "id": 2,
              "brand": 1,
              "company": 1,
              "invoice": null
          }
      ]
    """

  Scenario: Retrieve certain billable call json
    Given I add Authorization header
     When I add "Accept" header equal to "application/json"
      And I send a "GET" request to "billable_calls/1"
     Then the response status code should be 200
      And the response should be in JSON
      And the header "Content-Type" should be equal to "application/json; charset=utf-8"
      And the JSON should be like:
    """
      {
          "callid": "017cc7c8-eb38-4bbd-9318-524a274f7000",
          "startTime": "2019-01-01 09:00:00",
          "duration": 0,
          "caller": "+34633646464",
          "callee": "+34633656565",
          "cost": null,
          "price": 1,
          "priceDetails": [],
          "carrierName": null,
          "destinationName": null,
          "ratingPlanName": null,
          "endpointType": null,
          "endpointId": null,
          "direction": "outbound",
          "id": 1,
          "brand": "~",
          "company": "~",
          "invoice": "~"
      }
    """


  Scenario: Retrieve unpaginated billable call csv list
    Given I add Authorization header
    When I add "Accept" header equal to "text/csv"
    And I send a "GET" request to "billable_calls?_pagination=false"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "text/csv; charset=utf-8"
    And the response should be equal to
    """
callid,startTime,duration,caller,callee,cost,price,endpointType,endpointId,direction,id,brand,company,invoice
017cc7c8-eb38-4bbd-9318-524a274f7000,"2019-01-01 09:00:00",0,+34633646464,+34633656565,,1,,,outbound,1,1,1,1
017cc7c8-eb38-4bbd-9318-524a274f7001,"2019-01-01 09:00:01",0,+34633646464,+34633656565,,1,,,outbound,2,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7002,"2019-01-01 09:00:02",0,+34633646464,+34633656565,,1,,,outbound,3,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7003,"2019-01-01 09:00:03",0,+34633646464,+34633656565,,1,,,outbound,4,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7004,"2019-01-01 09:00:04",0,+34633646464,+34633656565,,1,,,outbound,5,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7005,"2019-01-01 09:00:05",0,+34633646464,+34633656565,,1,,,outbound,6,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7006,"2019-01-01 09:00:06",0,+34633646464,+34633656565,,1,,,outbound,7,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7007,"2019-01-01 09:00:07",0,+34633646464,+34633656565,,1,,,outbound,8,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7008,"2019-01-01 09:00:08",0,+34633646464,+34633656565,,1,,,outbound,9,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7009,"2019-01-01 09:00:09",0,+34633646464,+34633656565,,1,,,outbound,10,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7010,"2019-01-01 09:00:10",0,+34633646464,+34633656565,,1,,,outbound,11,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7011,"2019-01-01 09:00:11",0,+34633646464,+34633656565,,1,,,outbound,12,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7012,"2019-01-01 09:00:12",0,+34633646464,+34633656565,,1,,,outbound,13,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7013,"2019-01-01 09:00:13",0,+34633646464,+34633656565,,1,,,outbound,14,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7014,"2019-01-01 09:00:14",0,+34633646464,+34633656565,,1,,,outbound,15,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7015,"2019-01-01 09:00:15",0,+34633646464,+34633656565,,1,,,outbound,16,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7016,"2019-01-01 09:00:16",0,+34633646464,+34633656565,,1,,,outbound,17,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7017,"2019-01-01 09:00:17",0,+34633646464,+34633656565,,1,,,outbound,18,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7018,"2019-01-01 09:00:18",0,+34633646464,+34633656565,,1,,,outbound,19,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7019,"2019-01-01 09:00:19",0,+34633646464,+34633656565,,1,,,outbound,20,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7020,"2019-01-01 09:00:20",0,+34633646464,+34633656565,,1,,,outbound,21,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7021,"2019-01-01 09:00:21",0,+34633646464,+34633656565,,1,,,outbound,22,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7022,"2019-01-01 09:00:22",0,+34633646464,+34633656565,,1,,,outbound,23,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7023,"2019-01-01 09:00:23",0,+34633646464,+34633656565,,1,,,outbound,24,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7024,"2019-01-01 09:00:24",0,+34633646464,+34633656565,,1,,,outbound,25,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7025,"2019-01-01 09:00:25",0,+34633646464,+34633656565,,1,,,outbound,26,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7026,"2019-01-01 09:00:26",0,+34633646464,+34633656565,,1,,,outbound,27,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7027,"2019-01-01 09:00:27",0,+34633646464,+34633656565,,1,,,outbound,28,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7028,"2019-01-01 09:00:28",0,+34633646464,+34633656565,,1,,,outbound,29,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7029,"2019-01-01 09:00:29",0,+34633646464,+34633656565,,1,,,outbound,30,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7030,"2019-01-01 09:00:30",0,+34633646464,+34633656565,,1,,,outbound,31,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7031,"2019-01-01 09:00:31",0,+34633646464,+34633656565,,1,,,outbound,32,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7032,"2019-01-01 09:00:32",0,+34633646464,+34633656565,,1,,,outbound,33,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7033,"2019-01-01 09:00:33",0,+34633646464,+34633656565,,1,,,outbound,34,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7034,"2019-01-01 09:00:34",0,+34633646464,+34633656565,,1,,,outbound,35,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7035,"2019-01-01 09:00:35",0,+34633646464,+34633656565,,1,,,outbound,36,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7036,"2019-01-01 09:00:36",0,+34633646464,+34633656565,,1,,,outbound,37,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7037,"2019-01-01 09:00:37",0,+34633646464,+34633656565,,1,,,outbound,38,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7038,"2019-01-01 09:00:38",0,+34633646464,+34633656565,,1,,,outbound,39,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7039,"2019-01-01 09:00:39",0,+34633646464,+34633656565,,1,,,outbound,40,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7040,"2019-01-01 09:00:40",0,+34633646464,+34633656565,,1,,,outbound,41,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7041,"2019-01-01 09:00:41",0,+34633646464,+34633656565,,1,,,outbound,42,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7042,"2019-01-01 09:00:42",0,+34633646464,+34633656565,,1,,,outbound,43,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7043,"2019-01-01 09:00:43",0,+34633646464,+34633656565,,1,,,outbound,44,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7044,"2019-01-01 09:00:44",0,+34633646464,+34633656565,,1,,,outbound,45,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7045,"2019-01-01 09:00:45",0,+34633646464,+34633656565,,1,,,outbound,46,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7046,"2019-01-01 09:00:46",0,+34633646464,+34633656565,,1,,,outbound,47,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7047,"2019-01-01 09:00:47",0,+34633646464,+34633656565,,1,,,outbound,48,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7048,"2019-01-01 09:00:48",0,+34633646464,+34633656565,,1,,,outbound,49,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7049,"2019-01-01 09:00:49",0,+34633646464,+34633656565,,1,,,outbound,50,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7050,"2019-01-01 09:00:50",0,+34633646464,+34633656565,,1,,,outbound,51,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7051,"2019-01-01 09:00:51",0,+34633646464,+34633656565,,1,,,outbound,52,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7052,"2019-01-01 09:00:52",0,+34633646464,+34633656565,,1,,,outbound,53,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7053,"2019-01-01 09:00:53",0,+34633646464,+34633656565,,1,,,outbound,54,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7054,"2019-01-01 09:00:54",0,+34633646464,+34633656565,,1,,,outbound,55,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7055,"2019-01-01 09:00:55",0,+34633646464,+34633656565,,1,,,outbound,56,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7056,"2019-01-01 09:00:56",0,+34633646464,+34633656565,,1,,,outbound,57,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7057,"2019-01-01 09:00:57",0,+34633646464,+34633656565,,1,,,outbound,58,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7058,"2019-01-01 09:00:58",0,+34633646464,+34633656565,,1,,,outbound,59,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7059,"2019-01-01 09:00:59",0,+34633646464,+34633656565,,1,,,outbound,60,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7060,"2019-01-01 09:01:00",0,+34633646464,+34633656565,,1,,,outbound,61,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7061,"2019-01-01 09:01:01",0,+34633646464,+34633656565,,1,,,outbound,62,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7062,"2019-01-01 09:01:02",0,+34633646464,+34633656565,,1,,,outbound,63,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7063,"2019-01-01 09:01:03",0,+34633646464,+34633656565,,1,,,outbound,64,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7064,"2019-01-01 09:01:04",0,+34633646464,+34633656565,,1,,,outbound,65,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7065,"2019-01-01 09:01:05",0,+34633646464,+34633656565,,1,,,outbound,66,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7066,"2019-01-01 09:01:06",0,+34633646464,+34633656565,,1,,,outbound,67,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7067,"2019-01-01 09:01:07",0,+34633646464,+34633656565,,1,,,outbound,68,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7068,"2019-01-01 09:01:08",0,+34633646464,+34633656565,,1,,,outbound,69,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7069,"2019-01-01 09:01:09",0,+34633646464,+34633656565,,1,,,outbound,70,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7070,"2019-01-01 09:01:10",0,+34633646464,+34633656565,,1,,,outbound,71,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7071,"2019-01-01 09:01:11",0,+34633646464,+34633656565,,1,,,outbound,72,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7072,"2019-01-01 09:01:12",0,+34633646464,+34633656565,,1,,,outbound,73,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7073,"2019-01-01 09:01:13",0,+34633646464,+34633656565,,1,,,outbound,74,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7074,"2019-01-01 09:01:14",0,+34633646464,+34633656565,,1,,,outbound,75,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7075,"2019-01-01 09:01:15",0,+34633646464,+34633656565,,1,,,outbound,76,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7076,"2019-01-01 09:01:16",0,+34633646464,+34633656565,,1,,,outbound,77,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7077,"2019-01-01 09:01:17",0,+34633646464,+34633656565,,1,,,outbound,78,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7078,"2019-01-01 09:01:18",0,+34633646464,+34633656565,,1,,,outbound,79,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7079,"2019-01-01 09:01:19",0,+34633646464,+34633656565,,1,,,outbound,80,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7080,"2019-01-01 09:01:20",0,+34633646464,+34633656565,,1,,,outbound,81,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7081,"2019-01-01 09:01:21",0,+34633646464,+34633656565,,1,,,outbound,82,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7082,"2019-01-01 09:01:22",0,+34633646464,+34633656565,,1,,,outbound,83,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7083,"2019-01-01 09:01:23",0,+34633646464,+34633656565,,1,,,outbound,84,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7084,"2019-01-01 09:01:24",0,+34633646464,+34633656565,,1,,,outbound,85,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7085,"2019-01-01 09:01:25",0,+34633646464,+34633656565,,1,,,outbound,86,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7086,"2019-01-01 09:01:26",0,+34633646464,+34633656565,,1,,,outbound,87,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7087,"2019-01-01 09:01:27",0,+34633646464,+34633656565,,1,,,outbound,88,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7088,"2019-01-01 09:01:28",0,+34633646464,+34633656565,,1,,,outbound,89,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7089,"2019-01-01 09:01:29",0,+34633646464,+34633656565,,1,,,outbound,90,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7090,"2019-01-01 09:01:30",0,+34633646464,+34633656565,,1,,,outbound,91,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7091,"2019-01-01 09:01:31",0,+34633646464,+34633656565,,1,,,outbound,92,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7092,"2019-01-01 09:01:32",0,+34633646464,+34633656565,,1,,,outbound,93,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7093,"2019-01-01 09:01:33",0,+34633646464,+34633656565,,1,,,outbound,94,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7094,"2019-01-01 09:01:34",0,+34633646464,+34633656565,,1,,,outbound,95,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7095,"2019-01-01 09:01:35",0,+34633646464,+34633656565,,1,,,outbound,96,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7096,"2019-01-01 09:01:36",0,+34633646464,+34633656565,,1,,,outbound,97,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7097,"2019-01-01 09:01:37",0,+34633646464,+34633656565,,1,,,outbound,98,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7098,"2019-01-01 09:01:38",0,+34633646464,+34633656565,,1,,,outbound,99,1,1,
017cc7c8-eb38-4bbd-9318-524a274f7099,"2019-01-01 09:01:39",0,+34633646464,+34633656565,,1,,,outbound,100,1,1,
"""
