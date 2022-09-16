$(document).ready(function () {
  // required part
  $("#validate").validate({
    rules: {
      //Manage User validation
      name: {
        required: true,
      },
      roll: {
        required: true,
        number: true,
      },
      fName: {
        required: true,
      },
      fOccupation: {
        required: true,
      },
      mName: {
        required: true,
      },
      mOccupation: {
        required: true,
      },
      phoneNumber: {
        required: true,
        nunmber: true,
        minlength: 11,
      },
      email: {
        required: true,
        email: true,
      },
      presentAddress: {
        required: true,
      },
      permanentAddress: {
        required: true,
      },
      dob: {
        required: true,
      },
      birthId: {
        required: true,
        minlength: 13,
        number: true,
      },
      gender: {
        required: true,
      },
      bloodGroup: {
        required: true,
      },
      religion: {
        required: true,
      },
      dept_id: {
        required: true,
        number: true,
      },
      ffQuata: {
        required: true,
      },
      examRoll: {
        required: true,
        number: true,
      },
      merit: {
        required: true,
      },
      legalGuardianName: {
        required: false,
      },
      legalGuardianRelation: {
        required: false,
      },
      // Notice
      reference: {
        required: true,
      },
      details: {
        required: true,
      },
      title: {
        required: true,
      },
      details: {
        required: true,
      },
      //   Department
      name: {
        required: true,
      },
      short_form: {
        required: true,
      },
      //Roles
      role_name: {
        required: true,
      },
      value: {
        required: true,
      },
      //batch
      name: {
        required: true,
      },
      numaric_value: {
        required: true,
      },
      //fees
      amount: {
        required: true,
      },
      //role
      student_id: {
        required: true,
      },
      role: {
        required: true,
      },
      //expense
      expense_category_id: {
        required: true,
      },
      //forgot password 
      phoneNumber:{
        required: true,
      },
      password: {
        minlength: 8,
        required: true,
      }
      cpassword: {
        equalTo: "#password"
      }
    },
    messages: {},
  });
})